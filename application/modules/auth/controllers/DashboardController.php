<?php


class Auth_DashboardController extends Zend_Controller_Action {
  
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
    
    
    $_SESSION['flash'] = 'Le virement a été validé';
    $this->_redirect( '/auth/dashboard/virement' );
  }
  
  
}

