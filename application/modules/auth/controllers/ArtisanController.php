<?php


class Auth_ArtisanController extends Zend_Controller_Action {
  
  
  public function indexAction() {
    
    $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    
    $artisans = $this->getRequest()->_em->getRepository( 'Auth_Model_Artisan' )->findBy( [], [ 'id_artisan' => 'DESC' ] );
    
    $this->view->artisans = $artisans;
    
  }
  
  
  public function addAction() {
    
    $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    $em = $this->getRequest()->_em;
    
    
    // Initializing the forms
    $form = new Zend_Form();
    
    
    $form->addSubForms( [
      'form_artisan'  => new Auth_Form_Artisan,
      'form_chantier' => new Auth_Form_Chantier,
    ] );
    
    
    $activites = $em->getRepository( 'Auth_Model_Activite' )->getMultiOptions();
    $form->form_artisan->select_activites->setMultiOptions( $activites );
    
    $form->form_artisan->pass->setRequired( true );
    $form->form_artisan->pass2->setRequired( true );
    
    $this->view->form = $form;
    $this->render( 'edit' );
    
  }
  
  
  public function editAction() {
    
    // If it's an ajax request disable the layout
    if ( $this->getRequest()->isXmlHttpRequest() ) {
      $this->_helper->layout()->disableLayout();
    } else {
      $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    }
    
    $id = $this->getRequest()->getParam( 'id' );
    $em = $this->getRequest()->_em;
    
    // Load artisan;
    $artisan = $em->getRepository( 'Auth_Model_Artisan' )->find( $id );
    if ( ! $artisan ) {
      $artisan = new Auth_Model_Artisan;
    }
    
    
    // Initializing the forms
    $form = new Zend_Form();
    
    $form->addSubForms( [
      'form_artisan'  => new Auth_Form_Artisan,
      'form_chantier' => new Auth_Form_Chantier,
    ] );
    
    
    $form->form_chantier->code_postal->setAttrib( 'autocomplete', 'off' );
    $form->form_artisan->login
      ->setRequired( false )
      ->setAttribs( [ 'disabled' => 'disabled' ] );
    $form->form_artisan->email_artisan
      ->setRequired( false )
      ->setAttribs( [ 'disabled' => 'disabled' ] );
    
    
    $activites = $em->getRepository( 'Auth_Model_Activite' )->getMultiOptions();
    $form->form_artisan->select_activites->setMultiOptions( $activites );
    
    $form->setDefaults( [
      'Artisan'  => $artisan ? $artisan->toArray() : null,
      'Chantier' => $artisan->chantier ? $artisan->chantier->toArray() : null,
    ] );
    
    
    $form->form_chantier->setDefaults( [ 'code_postal' => $artisan->chantier->zone->code ] );
    
    // Proccess the posted data;
    if ( $this->getRequest()->isPost() ) {
      
      $data = $this->getRequest()->getPost();
      
      $form->form_artisan->pass2->addValidator( 'identical', false, $data['Artisan']['pass'] );
      
      $zone = $em->getRepository( 'Auth_Model_Zone' )->findOneBy( [ 'code' => $data['Chantier']['code_postal'] ] );
      
      $valid = $form->isValid( $data );
      
      if ( ! $zone ) {
        $form->form_chantier->code_postal->setAttribs( [ 'class' => 'has-error' ] );
      } else {
        $data['Chantier']['id_zone'] = $zone->getId_zone();
      }
      
      
      if ( $valid && $zone !== null ) {
        
        // We will send an email
        $sendEmail = false;
        
        if ( ! $artisan->notifie ) {
          $sendEmail                  = true;
          $data['Artisan']['notifie'] = true;
        }
        
        // Save the artisan
        $artisan = $em->getRepository( 'Auth_Model_Artisan' )->save( $id, $data );
        
        if ( $artisan ) {
          if ( $sendEmail ) {
            //$this->sendEmailNotifications( $artisan );
          }
        }
        
        
        $_SESSION['flash'] = "La mise à jour a été effectuée avec success";
        $this->getResponse()->setRedirect( "/auth/artisan" );
        
      } else // If the form is not valid keep the data provided by the user
      
      {
        $form->setDefaults( $data );
      }
      
    }
    
    
    $form->form_artisan->setDefault( 'pass', null );
    
    
    $this->view->artisan = $artisan;
    $this->view->form    = $form;
    $this->view->id      = $id;
  }
  
  
  public function profileAction() {
    
    $this->_helper->layout->setLayout( 'layout_fo_ehcg' );
    
    $id               = unserialize( Zend_Auth::getInstance()->getIdentity() )->id_user;
    $entity           = $this->getRequest()->_em->find( 'Auth_Model_Artisan', $id );
    $this->view->user = $entity;
    if ( $this->getRequest()->isPost() ) {
      # get params
      $data = $this->getRequest()->getPost();
      
      $accountExist = $this->getRequest()->_em->getRepository( 'Auth_Model_Artisan' )->findBy( [ 'email_user' => (string) $data['EMAIL_USER'] ] );
      if ( count( $accountExist ) == 0 || count( $accountExist ) == 1 && $accountExist[0]->getId_user() == $entity->id_user ) {
        $entity->firstname_user = $data['FIRSTNAME_USER'];
        $entity->lastname_user  = $data['LASTNAME_USER'];
        $entity->email_user     = $data['EMAIL_USER'];
        $entity->login_user     = $data['LOGIN_USER'];
        
        if ( ! empty( $data['PASSWORD_USER'] ) ) {
          $entity->setPassword( $data['PASSWORD_USER'], $this->getRequest()->_registry->config->auth->hash );
        }
        
        $this->getRequest()->_em->persist( $entity );
        $this->getRequest()->_em->flush();
        $this->getRequest()->_cache->remove( 'Artisan' );
        
        $this->_helper->redirector( 'index', 'user', 'auth' );
      }
    }
  }
  
  public function removeAction() {
    
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender();
    
    # get params
    $id = $this->_getParam( "id" );
    
    $entity = $this->getRequest()->_em->find( 'Auth_Model_Artisan', $id );
    $this->getRequest()->_em->remove( $entity );
    $this->getRequest()->_em->flush();
    $this->getRequest()->_cache->remove( 'Artisan' );
    $this->_helper->json->sendJson( [ 'response' => true ] );
  }
  
  
  public function permissionAction() {
    
    Zend_Registry::get( 'acl' )->isAllowed( new Custom_Acl_ArtisanRole(), new Custom_Acl_Resources( 'devis' ), 'view' );
    
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender();
  }
  
  public function enableAction() {
    
    $idArtisan = (int) $this->getRequest()->getParam( 'listId', 0 );
    $user      = $this->getRequest()->_em->getRepository( 'Auth_Model_Artisan' )->find( $idArtisan );
    $user->setstatususer( 1 );
    
    $this->getRequest()->_em->persist( $user );
    $this->getRequest()->_em->flush();
    $this->getRequest()->_cache->remove( 'Artisan' );
    
    echo json_encode( [
      "response" => "true",
      "message"  => "Changement de statut effectué.",
    ] );
    
    $this->_helper->viewRenderer->setNoRender();
    $this->_helper->layout()->disableLayout();
    
    
  }
  
  public function disableAction() {
    
    $idArtisan = (int) $this->getRequest()->getParam( 'listId', 0 );
    $user      = $this->getRequest()->_em->getRepository( 'Auth_Model_Artisan' )->find( $idArtisan );
    $user->setstatususer( 0 );
    
    $this->getRequest()->_em->persist( $user );
    $this->getRequest()->_em->flush();
    $this->getRequest()->_cache->remove( 'Artisan' );
    
    echo json_encode( [
      "response" => "true",
      "message"  => "Changement de statut effectué.",
    ] );
    
    $this->_helper->viewRenderer->setNoRender();
    $this->_helper->layout()->disableLayout();
    
  }
  
  public function deleteAction() {
    
    $idArtisan       = (int) $this->getRequest()->getParam( 'listId', 0 );
    $users           = $this->getRequest()->_em->getRepository( 'Auth_Model_Artisan' )->find( $idArtisan );
    $estimate        = $this->getRequest()->_em->getRepository( 'Auth_Model_Estimate' )->findByIduser( $idArtisan );
    $user            = $this->getRequest()->_em->find( 'Auth_Model_Artisan', unserialize( Zend_Auth::getInstance()->getIdentity() )->iduser );
    $usersConnection = $this->getRequest()->_em->getRepository( 'Auth_Model_Connections' )->findByiduser( $idArtisan );
    
    foreach ( $usersConnection as $u ) {
      $this->getRequest()->_em->remove( $u );
    }
    foreach ( $estimate as $e ) {
      $e->iduser = $user;
      $this->getRequest()->_em->persist( $e );
    }
    //$this->getRequest()->_em->flush();
    $this->getRequest()->_em->remove( $users );
    $this->getRequest()->_em->flush();
    $this->getRequest()->_cache->remove( 'Artisan' );
    
    echo json_encode( [
      "response" => "true",
      "message"  => "Suppression effectuée.",
    ] );
    $this->_helper->viewRenderer->setNoRender();
    $this->_helper->layout()->disableLayout();
  }
  
  public function countrecordsAction() {
    
    $total = $this->getRequest()->_em->getRepository( 'Auth_Model_Artisan' )->getCount();
    $this->_helper->json->sendJson( $total );
    $this->_helper->viewRenderer->setNoRender();
    $this->_helper->layout()->disableLayout();
  }
  
  
  public function newactiviteAction() {
    
    $em = $this->getRequest()->_em;
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender( true );
    
    $this->getResponse()->setHeader( 'Content-Type', 'application/json' );
    
    
    $form = new Auth_Form_Artisan;
    
    $activites = $em->getRepository( 'Auth_Model_Activite' )->getMultiOptions();
    $form->select_activites->setMultiOptions( $activites )->setLabel( null );
    
    echo json_encode( [
      'error' => 0,
      'html'  => $this->view->partial( "artisan/newactivite.phtml", [ 'form' => $form ] ),
    ] );
    
  }
  
}

