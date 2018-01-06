<?php


class Auth_DashboardController extends Zend_Controller_Action {
  
  private $_sys_email;
  
  public function init() {
    
    $config           = new Zend_Config_Ini( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
    $this->_sys_email = $config->system->email->toArray();
  }
  
  public function indexAction() {
    
    $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    $em = $this->getRequest()->_em;
    
    
    $countpiscine              = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'type' => 'Piscine' ] );
    $countchauffage            = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'type' => 'Chauffage' ] );
    $countclimatisation        = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'type' => 'Climatisation' ] );
    $countfenetre              = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'type' => 'Fenetre' ] );
    $countdevisqualifie        = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'qualification' => 'Qualifié' ] );
    $countdevisnonqualifie     = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'qualification' => 'Non qualifiée' ] );
    $countdevisnrp             = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'qualification' => 'NRP' ] );
    $countdevistard            = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'qualification' => 'Trop tard' ] );
    $countvendu                = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'sold' => true ] );
    $countvenducarte           = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'payement' => 'cart' ] );
    $countvenduvirementvalide  = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'payement' => 'virement', 'sold' => true ] );
    $countvenduvirementencours = $em->getRepository( 'Auth_Model_Demandedevis' )->countBy( [ 'payement' => 'virement', 'sold' => false ] );
    
    
    $this->view->countpiscine              = $countpiscine;
    $this->view->countchauffage            = $countchauffage;
    $this->view->countclimatisation        = $countclimatisation;
    $this->view->countfenetre              = $countfenetre;
    $this->view->countdevisqualifie        = $countdevisqualifie;
    $this->view->countdevisnonqualifie     = $countdevisnonqualifie;
    $this->view->countdevisnrp             = $countdevisnrp;
    $this->view->countdevistard            = $countdevistard;
    $this->view->countvendu                = $countvendu;
    $this->view->countvenducarte           = $countvenducarte;
    $this->view->countvenduvirementvalide  = $countvenduvirementvalide;
    $this->view->countvenduvirementencours = $countvenduvirementencours;
  }
  
  public function virementAction() {
    
    $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    $em = $this->getRequest()->_em;
    
    
    $achats = $em->getRepository( 'Auth_Model_Acheter' )->findBy( [
      'mode_paiement' => 'VIREMENT BANCAIRE',
      'reglee'        => 0,
    ] );
    
    $this->view->achats = $achats;
  }
  
  
  public function virementValiderAction() {
    
    $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    $em = $this->getRequest()->_em;
    
    $id_artisan = $this->getRequest()->getParam( 'artisan' );
    $id_demande = $this->getRequest()->getParam( 'demande' );
    
    
    $achat = $em->getRepository( 'Auth_Model_Acheter' )->findOneBy( [
      'id_artisan' => $id_artisan,
      'id_demande' => $id_demande,
    ] );
    
    
    if ( ! $achat ) {
      $this->_redirect( '/auth/dashboard/virement' );
    }
    
    
    $date = new Zend_Date();
    
    
    $ref = $achat->demande->getRef();
    
    // Fetching the html for the invoice from the view
    $html = $this->view->partial( 'shared/facture.phtml', [
      'demande' => $achat->demande,
      'artisan' => $achat->artisan,
    ] );
    
    $this->generateFacture( $ref . "-" . $achat->id_artisan, $html );
    
    $pdf_location     = $achat->demande->pdfLocation( true );
    $facture_location = $achat->demande->factureLocation( $achat->id_artisan, true );
    
    $pdf_content     = file_get_contents( $pdf_location );
    $facture_content = file_get_contents( $facture_location );
    
    // Preparing attachements
    $pdf_attachement              = new Zend_Mime_Part( $pdf_content );
    $pdf_attachement->type        = 'application/pdf';
    $pdf_attachement->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
    $pdf_attachement->encoding    = Zend_Mime::ENCODING_BASE64;
    $pdf_attachement->filename    = $ref . ".pdf";
    
    $facture_attachement              = new Zend_Mime_Part( $facture_content );
    $facture_attachement->type        = 'application/pdf';
    $facture_attachement->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
    $facture_attachement->encoding    = Zend_Mime::ENCODING_BASE64;
    $facture_attachement->filename    = "FAC-{$ref}-{$achat->id_artisan}.pdf";
    
    
    // Sending email
    try {
      
      $html = $this->view->partial( 'shared/mail_invoice_artisan.phtml', [
        'artisan' => $achat->artisan,
        'demande' => $achat->demande,
        'acheter' => $achat,
      ] );
      
      $mail = new Zend_Mail( 'utf-8' );
      $mail->setBodyHtml( $html );
      $mail->setFrom( $this->_sys_email['address'], $this->_sys_email['name'] );
      $mail->setSubject( "Votre commande du " . $date->toString( 'd MMMM Y' ) . " sur Mister Devis est complète" );
      $mail->addTo( $achat->artisan->email_artisan );
      $mail->addAttachment( $pdf_attachement );
      $mail->addAttachment( $facture_attachement );
      
      $mail->send();
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
    
    
    // Flaging the transaction as sold
    $achat->setReglee( true );
    $em->persist( $achat );
    $em->flush();
    
    
    $_SESSION['flash'] = 'Le virement a été validé';
    $this->_redirect( '/auth/dashboard/virement' );
  }
  
  
  private function generateFacture( $ref, $html ) {
    
    $filename = "pdf/factures/FAC-{$ref}.pdf";
    
    // Initializing the pdf object
    $pdf = new Auth_Controller_Helper_MyPdf( 'P', 'mm', 'A4', true, 'UTF-8', false );
    
    
    // Set document info
    $pdf->SetAuthor( 'MisterDevis' );
    $pdf->SetTitle( "FAC-{$ref}" );
    
    
    // Set the page
    $pdf->AddPage();
    
    $pdf->writeHTML( $html );
    
    $pdf->Output( $filename, 'F' );
    
    return $filename;
  }
}

