<?php
class Auth_PiscineController extends Zend_Controller_Action
{

    public function indexAction()
    {
    	//$this->_helper->layout()->disableLayout();
		$this->_helper->layout->setLayout ( 'layout_fo_ehcg' );
		
		$listpiscine=$this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findlist();
		
		$this->view->listpiscine = $listpiscine;
    }
    
	public function notificationAction()
	{
		$lien=array();
		$dataNotif = $this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findNewRowsPiscine();
		$i=0;
		foreach ( $dataNotif as $n ) {	
			$lien [$i] = '/auth/piscine/edit/id_demande/' . $n[id_demande];
			$i++;
		}
		
		$totalLastNotif = count($dataNotif);
		//var_dump($dataNotif);
		$this->view->total = $totalLastNotif;
		$this->view->lien = $lien;
		$this->view->lastNotifications = $dataNotif;
		//$this->view->dt = $calcule;
	}
	
	public function filterAction() {
		$filter = $this->_request->getParam ( 'filter' );
		if (! empty ( $filter )) {
			$this->view->filtre = $filter;
		}
	}
	
	public function editAction(){
		
		$this->_helper->layout->setLayout ( 'layout_fo_ehcg' );
		$id = $this->getRequest()->getParam('id_demande');
				
		$demandedevis = $this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findDemandeDevis($id);
		$piscine = $this->getRequest()->_em->getRepository('Auth_Model_Piscine')->findBy(array('id_demande' => $id));
		$zones = $this->getRequest()->_em->getRepository('Auth_Model_Zone')->findAll();
		
		$this->view->id_demande=$id;
		$this->view->demandedevis=$demandedevis;
		$this->view->piscine=$piscine;
		$this->view->zones=$zones;
		
		if ($this->getRequest()->isPost()) {

            # get params
            $data = $this->getRequest()->getPost();
			
			$estimate = $this->getRequest()->_em->find('Auth_Model_Estimate', $data['idestimate']);
            $user = $this->getRequest()->_em->find('Auth_Model_User', unserialize(Zend_Auth::getInstance()->getIdentity())->iduser);
		}
	}
	
    
}
