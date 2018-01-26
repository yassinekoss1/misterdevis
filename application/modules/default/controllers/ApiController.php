<?php


class ApiController extends Zend_Controller_Action {
  
  private $_sys_email;
  
  
  public function init() {
    
    $config           = new Zend_Config_Ini( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
    $this->_sys_email = $config->system->email->toArray();
  }
  
  
  public function indexAction() {
    
    try {
      $em = $this->getRequest()->_em;
      
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender( true );
      
      $form_id = $this->getRequest()->getParam( 'ID_FORM' );
      $data    = $this->getRequest()->getPost();
      
      $hash = $this->getRequest()->_registry->config->auth->hash;
      
      if ( $form_id == '2' ) {
        
        $activites = $em->getRepository( 'Auth_Model_Activite' )->findBy( [ 'ref' => $data['ID_ACTIVITE'] ] );
        
        $departement = $em->getRepository( 'Auth_Model_Departement' )->createQueryBuilder( 'd' )
                          ->innerJoin( 'd.zones', 'z' )
                          ->where( 'z.code = :code' )
                          ->setParameter( 'code', $data['CODE_POSTAL'] )
                          ->getQuery()
                          ->getOneOrNullResult();
        
        $artisan = new Auth_Model_Artisan;
        $artisan->setPrenom_artisan( urldecode( $data['PRENOM_ARTISAN'] ) );
        $artisan->setNom_artisan( urldecode( $data['NOM_ARTISAN'] ) );
        $artisan->setRaison_sociale( urldecode( $data['RAISON_SOCIALE'] ) );
        $artisan->setTelephone_fixe( urldecode( $data['TELEPHONE_FIXE'] ) );
        $artisan->setTelephone_portable( urldecode( $data['TELEPHONE_PORTABLE'] ) );
        $artisan->setEmail_artisan( urldecode( $data['EMAIL_ARTISAN'] ) );
        $artisan->setHoraireRDV( urldecode( $data['HORAIRERDV'] ) );
        $artisan->setCode_postal( $data['CODE_POSTAL'] );
        $artisan->setLogin( urlencode( $data['LOGIN'] ) );
        $artisan->setPass( (string) hash( 'SHA256', $hash . $data['PASS'] ) );
        
        
        foreach ( $activites as $activite ) {
          $artisan->addActivite( $activite );
        }
        
        $artisan->addDepartement( $departement );
        
        $em->persist( $artisan );
        $em->flush();
        
        $this->view->artisan = $artisan;
        $this->view->pass    = $data['PASS'];
        
        $html = $this->view->render( 'shared/new_artisan_mail.phtml' );
        
        
        $mail = new Zend_Mail( 'utf-8' );
        $mail->setBodyHtml( $html );
        $mail->setFrom( $this->_sys_email['address'], $this->_sys_email['name'] );
        $mail->setSubject( "Inscription Mister Devis Pro" );
        $mail->addTo( $artisan->email_artisan );
        
        $mail->send();
        
      } else if ( $form_id == '3' ) { // A new particulier request
        
        // Fetch the activite
        $activite = $em->getRepository( 'Auth_Model_Activite' )->findOneBy( [ 'ref' => $data['ID_ACTIVITE'] ] );
        
        
        // Saving particulier data
        $particulier = new Auth_Model_Particulier;
        $particulier->setNom_particulier( urldecode( $data['NOM_PARTICULIER'] ) );
        $particulier->setPrenom_particulier( urldecode( $data['PRENOM_PARTICULIER'] ) );
        $particulier->setTelephone_portable( urldecode( $data['TELEPHONE_PORTABLE'] ) );
        $particulier->setEmail( urldecode( $data['EMAIL'] ) );
        
        $em->persist( $particulier );
        $em->flush();
        
        // Saving demande data
        $demande = new Auth_Model_Demandedevis;
        $demande->setId_particulier( $particulier );
        $demande->setId_activite( $activite );
        $demande->setDate_creation( date( 'Y-m-d H:i:s' ) );
        
        $em->persist( $demande );
        $em->flush();
        
        
        $ops = $em->getRepository( 'Auth_Model_User' )->getOperatorsEmails();
        
        
        $data = [
          'ops'          => $ops,
          'particuliers' => [
            [
              'nom_particulier'   => $demande->getId_particulier()->getNom_particulier(),
              'email_particulier' => $demande->getId_particulier()->getEmail(),
            ],
          ],
          'ref'          => $demande->getRef(),
          'url'          => $demande->getUrl(),
        ];
        
        $data_string = json_encode( $data );
        
        
        $ch = curl_init( '127.0.0.1:9090' );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: ' . md5( 'erratbi' ),
          'Content-Length: ' . strlen( $data_string ),
        ] );
        
        curl_exec( $ch );
        
        
        echo '';
      }
    } catch ( Exception $e ) {
      die( $e->getMessage() );
    }
    
  }
}
