<?php


class Auth_ApiController extends Zend_Controller_Action {
  
  private $_sys_email;
  
  public function init() {
    
    $config           = new Zend_Config_Ini( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
    $this->_sys_email = $config->system->email->toArray();
  }
  
  
  public function demandesAction() {
    
    $em = $this->getRequest()->_em;
    
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender( true );
    
    $this->getResponse()->setHeader( 'Content-Type', 'application/json' );
    
    $email = urldecode( $this->getRequest()->getPost( 'email' ) );
    
    $artisan = $em->getRepository( 'Auth_Model_Artisan' )->findOneBy( [ 'email_artisan' => $email ] );
    
    
    if ( ! $artisan ) {
      echo json_encode( [] );
    } else {
      $demandes = $em->getRepository( 'Auth_Model_Demandedevis' )->findOpenJobs( $artisan->email_artisan );
      
      
      $resp = array_map( function ( $demande ) use ( $artisan ) {
        
        return [
          'id'                  => $demande->getId_demande(),
          'titre'               => $demande->getTitre_demande(),
          'libelle'             => "$demande->titre_demande {$demande->getRef()}",
          'type'                => ucfirst( strtolower( $demande->getId_activite()->getLibelle() ) ),
          'prix'                => $demande->getPrix_mise_en_ligne(),
          'ref'                 => $demande->getRef(),
          'ville'               => $demande->getId_chantier()->getZone()->getVille(),
          'icon'                => $demande->getType() . '.png',
          'code_postal'         => $demande->getId_chantier()->getZone()->getCode(),
          'type_demandeur'      => $demande->getType_demandeur(),
          'type_propriete'      => $demande->getType_propriete(),
          'type_batiment'       => $demande->getType_batiment(),
          'delai_souhaite'      => $demande->getDelai_souhaite(),
          'budget_approximatif' => $demande->getBudget_approximatif(),
          'financement_projet'  => $demande->getFinancement_projet(),
          'objectif_demande'    => $demande->getObjectif_demande(),
          'description'         => $demande->getDescription(),
          'tva'                 => ( (float) $demande->getPrix_mise_en_ligne() ) * 0.2,
          'prixttc'             => ( (float) $demande->getPrix_mise_en_ligne() ) * 1.2,
          'nom_artisan'         => $artisan->getNom_artisan(),
          'prenom_artisan'      => $artisan->getPrenom_artisan(),
          'email_artisan'       => $artisan->getEmail_artisan(),
          'raison_sociale'      => $artisan->getRaison_sociale(),
          'telephone_portable'  => $artisan->getTelephone_portable(),
          'adresse'             => $artisan->getChantier()->getAdresse(),
        ];
        
      }, $demandes );
      
      echo json_encode( $resp );
    }
  }
  
  
  public function demandeAction() {
    
    $em = $this->getRequest()->_em;
    
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender( true );
    
    $this->getResponse()->setHeader( 'Content-Type', 'application/json' );
    
    $id = $this->getRequest()->getParam( 'id' );
    if ( ! $id ) {
      echo json_encode( [] );
      
      return;
    }
    
    $demande = $em->getRepository( 'Auth_Model_Demandedevis' )->find( $id );
    
    if ( ! $demande ) {
      echo json_encode( [] );
    } else {
      echo json_encode( [
        'id'                  => $demande->id_demande,
        'titre'               => $demande->titre_demande,
        'ref'                 => $demande->getRef(),
        'libelle'             => "$demande->titre_demande {$demande->getRef()}",
        'prix'                => $demande->getPrix_mise_en_ligne(),
        'ville'               => $demande->getId_chantier()->getZone()->getVille(),
        'code_postal'         => $demande->getId_chantier()->getZone()->getCode(),
        'type_demandeur'      => $demande->getType_demandeur(),
        'type_propriete'      => $demande->getType_propriete(),
        'type_batiment'       => $demande->getType_batiment(),
        'delai_souhaite'      => $demande->getDelai_souhaite(),
        'budget_approximatif' => $demande->getBudget_approximatif(),
        'financement_projet'  => $demande->getFinancement_projet(),
        'objectif_demande'    => $demande->getObjectif_demande(),
        'description'         => $demande->getDescription(),
      ] );
    }
  }
  
  public function checkoutAction() {
    
    $em = $this->getRequest()->_em;
    
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender( true );
    
    $this->getResponse()->setHeader( 'Content-Type', 'application/json' );
    
    $id = $this->getRequest()->getParam( 'id' );
    if ( ! $id ) {
      echo json_encode( [] );
      
      return;
    }
    
    $email = $this->getRequest()->getParam( 'email' );
    
    $artisan = $em->getRepository( 'Auth_Model_Artisan' )->findOneBy( [ 'email_artisan' => $email ] );
    
    $demande = $em->getRepository( 'Auth_Model_Demandedevis' )->find( $id );
    
    if ( ! $demande ) {
      echo json_encode( [] );
    } else {
      echo json_encode( [
        'id'                 => $demande->id_demande,
        'titre'              => $demande->titre_demande,
        'ref'                => $demande->getRef(),
        'libelle'            => "$demande->titre_demande {$demande->getRef()}",
        'nom_artisan'        => $artisan->getNom_artisan(),
        'prenom_artisan'     => $artisan->getPrenom_artisan(),
        'email_artisan'      => $artisan->getEmail_artisan(),
        'raison_sociale'     => $artisan->getRaison_sociale(),
        'telephone_portable' => $artisan->getTelephone_portable(),
        'adresse'            => $artisan->getChantier()->getAdresse(),
        'prix'               => $demande->getPrix_mise_en_ligne(),
        'tva'                => ( (float) $demande->getPrix_mise_en_ligne() ) * 0.2,
        'prixttc'            => ( (float) $demande->getPrix_mise_en_ligne() ) * 1.2,
      ] );
    }
  }
  
  public function updateAction() {
    
    $date = new Zend_Date();
    
    $em = $this->getRequest()->_em;
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender( true );
    
    $id    = $this->getRequest()->getPost( 'id' );
    $email = urldecode( $this->getRequest()->getPost( 'email' ) );
    
    
    $artisan = $em->getRepository( 'Auth_Model_Artisan' )->findOneBy( [ 'email_artisan' => $email ] );
    $demande = $em->getRepository( 'Auth_Model_Demandedevis' )->find( $id );
    
    $ref = $demande->getRef();
    
    //Saving and generating Facture
    try {
      $acheter = new Auth_Model_Acheter();
      
      $acheter->setArtisan( $artisan );
      $acheter->setId_artisan( $artisan->id_artisan );
      $acheter->setDemande( $demande );
      $acheter->setId_demande( $demande->id_demande );
      $acheter->setReglee( true );
      $acheter->setMode_paiement( 'CARTE BANCAIRE' );
      
      $em->persist( $acheter );
      $em->flush();
      
      // Fetching the html string from the view
      $html = $this->view->partial( 'shared/facture.phtml', [
        'demande' => $demande,
        'artisan' => $artisan,
      ] );
      
      $this->generateFacture( $ref . "-" . $artisan->id_artisan, $html );
      
      
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
    
    
    $pdf_location     = $demande->pdfLocation( true );
    $facture_location = $demande->factureLocation( $artisan->id_artisan, true );
    
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
    $facture_attachement->filename    = "FAC-{$ref}-{$artisan->id_artisan}.pdf";
    
    
    // Sending email to artisan
    try {
      
      $html = $this->view->partial( 'shared/mail_invoice_artisan.phtml', [
        'artisan' => $artisan,
        'demande' => $demande,
        'acheter' => $acheter,
      ] );
      
      $mail = new Zend_Mail( 'utf-8' );
      $mail->setBodyHtml( $html );
      $mail->setFrom( $this->_sys_email['address'], $this->_sys_email['name'] );
      $mail->setSubject( "Votre commande du " . $date->toString( 'd MMMM Y' ) . " sur Mister Devis est complète" );
      $mail->addTo( $artisan->email_artisan );
      $mail->addAttachment( $pdf_attachement );
      $mail->addAttachment( $facture_attachement );
      
      $mail->send();
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
    
    // Sending email to particulier
    
    try {
      
      $html = $this->view->partial( 'shared/mail_confirme_particulier.phtml', [
        'artisan'     => $artisan,
        'particulier' => $demande->id_particulier,
      ] );
      
      $mail = new Zend_Mail( 'utf-8' );
      $mail->setBodyHtml( $html );
      $mail->setFrom( $this->_sys_email['address'], $this->_sys_email['name'] );
      $mail->setSubject( "Un artisan est intérssé par votre demande de devis" );
      $mail->addTo( $demande->id_particulier->email );
      
      $mail->send();
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
  }
  
  
  public function virementAction() {
    
    $date = new Zend_Date();
    
    $em = $this->getRequest()->_em;
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender( true );
    
    $id    = $this->getRequest()->getPost( 'id' );
    $email = urldecode( $this->getRequest()->getPost( 'email' ) );
    
    
    $artisan = $em->getRepository( 'Auth_Model_Artisan' )->findOneBy( [ 'email_artisan' => $email ] );
    $demande = $em->getRepository( 'Auth_Model_Demandedevis' )->find( $id );
    
    //Saving and generating Facture
    try {
      $acheter = new Auth_Model_Acheter();
      
      $acheter->setArtisan( $artisan );
      $acheter->setId_artisan( $artisan->id_artisan );
      $acheter->setDemande( $demande );
      $acheter->setId_demande( $demande->id_demande );
      $acheter->setReglee( false );
      $acheter->setMode_paiement( 'VIREMENT BANCAIRE' );
      
      $em->persist( $acheter );
      $em->flush();
      
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
    
    // Sending email
    try {
      
      $html = $this->view->partial( 'shared/mail_virement_artisan.phtml', [
        'artisan' => $artisan,
        'demande' => $demande,
      ] );
      
      $mail = new Zend_Mail( 'utf-8' );
      $mail->setBodyHtml( $html );
      $mail->setFrom( $this->_sys_email['address'], $this->_sys_email['name'] );
      $mail->setSubject( "Reçu de votre commande du " . $date->toString( 'd MMMM Y' ) . " sur Mister Devis" );
      $mail->addTo( $artisan->email_artisan );
      
      $mail->send();
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
    
  }
  
  
  private function generateFacture( $ref, $html ) {
    
    $filename = "pdf/factures/FAC-{$ref}.pdf";
    
    // Initializing the pdf object
    $pdf = new Auth_Controller_Helper_MyPdf2( 'P', 'mm', 'A4', true, 'UTF-8', false );
    
    
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
