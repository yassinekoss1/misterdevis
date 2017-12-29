<?php
/**
 * Auth Category2 Controller
 *
 *
 * @author          Lamari Alaa
 * @package       Auth Module
 *
 */
class Auth_UserController extends Zend_Controller_Action
{

	/**
     * default method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
    public function indexAction()
    {
		
		$this->_helper->layout->setLayout ( 'layout_fo_ehcg' );
		
		$listeuser = $this->getRequest()->_em->getRepository('Auth_Model_User')->findAll();
		
		$this->view->listeuser = $listeuser;


    }
    
	/**
     * default method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
    
  	
   
    
	public function addAction()
    {
        $this->_helper->layout->setLayout ( 'layout_fo_ehcg' );
        
        
    	if($this->getRequest()->isPost())
    	{
            $data = $this->_request->getPost();
			     	
			# check for existing email
			$accountExist = $this->getRequest()->_em->getRepository('Auth_Model_User')->findBy(array('email_user' => (string)$data['EMAIL_USER']));
			if(count($accountExist) == 0)
			{
				var_dump($data);
				
				$entity = new Auth_Model_User;
				$entity->email_user = $data['EMAIL_USER'];
				$entity->firstname_user = $data['FIRSTNAME_USER'];
				$entity->lastname_user = $data['LASTNAME_USER'];
				$entity->login_user = $data['LOGIN_USER'];
				$entity->rank_user = 0;
				$entity->isActive_user = $data['ISACTIVE_USER'];
				$entity->dateregister_user=date("Y-m-d h:i:s");	   
				$entity->setPassword($data['PASSWORD_USER'], $this->getRequest()->_registry->config->auth->hash);
				$this->getRequest()->_em->persist($entity);
				$this->getRequest()->_em->flush();
				$this->getRequest()->_cache->remove('User');
				
				$this->_helper->redirector('index', 'user', 'auth');
				
			 }
			 else {
				 $response = 'Enregistrement impossible : Cet email existe déjà';
			 }
            
    		
        }
        
    }
    
	public function editAction(){
		
		$this->_helper->layout->setLayout ( 'layout_fo_ehcg' );
		
		$id = $this->getRequest()->getParam('id');
        $entity = $this->getRequest()->_em->find('Auth_Model_User', $id);
		$this->view->user=$entity;
		if($this->getRequest()->isPost())
        {
        	# get params
        	$data = $this->getRequest()->getPost();
			
			$accountExist = $this->getRequest()->_em->getRepository('Auth_Model_User')->findBy(array('email_user' => (string)$data['EMAIL_USER']));
			if(count($accountExist) == 0 || count($accountExist) == 1 && $accountExist[0]->getId_user() == $entity->id_user)
        	    {
					$entity->firstname_user=$data['FIRSTNAME_USER'];
					$entity->lastname_user=$data['LASTNAME_USER'];
					$entity->email_user=$data['EMAIL_USER'];
					$entity->login_user=$data['LOGIN_USER'];
					$entity->isActive_user=$data['ISACTIVE_USER'];
					
					if(!empty($data['PASSWORD_USER'])){
						$entity->setPassword($data['PASSWORD_USER'], $this->getRequest()->_registry->config->auth->hash);
					}
					
					$this->getRequest()->_em->persist($entity);
		        	$this->getRequest()->_em->flush();
		        	$this->getRequest()->_cache->remove('User');
					
					$this->_helper->redirector('index', 'user', 'auth');
				}
		}
	}
	
	public function profileAction(){
		$this->_helper->layout->setLayout ( 'layout_fo_ehcg' );
		
		$id = unserialize(Zend_Auth::getInstance()->getIdentity())->id_user;
        $entity = $this->getRequest()->_em->find('Auth_Model_User', $id);
		$this->view->user=$entity;
		if($this->getRequest()->isPost())
        {
        	# get params
        	$data = $this->getRequest()->getPost();
			
			$accountExist = $this->getRequest()->_em->getRepository('Auth_Model_User')->findBy(array('email_user' => (string)$data['EMAIL_USER']));
			if(count($accountExist) == 0 || count($accountExist) == 1 && $accountExist[0]->getId_user() == $entity->id_user)
        	    {
					$entity->firstname_user=$data['FIRSTNAME_USER'];
					$entity->lastname_user=$data['LASTNAME_USER'];
					$entity->email_user=$data['EMAIL_USER'];
					$entity->login_user=$data['LOGIN_USER'];
					
					if(!empty($data['PASSWORD_USER'])){
						$entity->setPassword($data['PASSWORD_USER'], $this->getRequest()->_registry->config->auth->hash);
					}
					
					$this->getRequest()->_em->persist($entity);
		        	$this->getRequest()->_em->flush();
		        	$this->getRequest()->_cache->remove('User');
					
					$this->_helper->redirector('index', 'user', 'auth');
				}
		}
	}

    public function removeAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        # get params
        $id = $this->_getParam("id");
        
        $entity = $this->getRequest()->_em->find('Auth_Model_User', $id);
        $this->getRequest()->_em->remove($entity);
        $this->getRequest()->_em->flush();
        $this->getRequest()->_cache->remove('User');
        $this->_helper->json->sendJson(array('response' => true));
    }
    
    
   
    
	

    public function permissionAction()
    {
    	Zend_Registry::get('acl')->isAllowed(new Custom_Acl_UserRole(), new Custom_Acl_Resources('devis'),'view');
    	
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
    }
    
	public function enableAction()
    {
    	$idUser= (int) $this->getRequest()->getParam('listId',0);
   		$user= $this->getRequest()->_em->getRepository('Auth_Model_User')->find($idUser);
   		$user->setstatususer(1);
 
   		$this->getRequest()->_em->persist($user);
   		$this->getRequest()->_em->flush();
   		$this->getRequest()->_cache->remove('User');
   		
   		echo json_encode(array(
					"response" => "true",
					"message" => "Changement de statut effectué."	    				
				));
   		
    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
    	
    
    }
    
	public function disableAction()
    {
    	$idUser= (int) $this->getRequest()->getParam('listId',0);
   		$user= $this->getRequest()->_em->getRepository('Auth_Model_User')->find($idUser);
   		$user->setstatususer(0);
 
   		$this->getRequest()->_em->persist($user);
   		$this->getRequest()->_em->flush();
   		$this->getRequest()->_cache->remove('User');
   		
   		echo json_encode(array(
					"response" => "true",
					"message" => "Changement de statut effectué."	    				
				));
   		
    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
    
    }
    
   public function deleteAction()
   {
    	$idUser= (int) $this->getRequest()->getParam('listId',0);
   		$users= $this->getRequest()->_em->getRepository('Auth_Model_User')->find($idUser);
   		$estimate= $this->getRequest()->_em->getRepository('Auth_Model_Estimate')->findByIduser($idUser);
   		$user = $this->getRequest()->_em->find('Auth_Model_User', unserialize(Zend_Auth::getInstance()->getIdentity())->iduser);
   		$usersConnection= $this->getRequest()->_em->getRepository('Auth_Model_Connections')->findByiduser($idUser);
   		
   		foreach($usersConnection as $u){
   			$this->getRequest()->_em->remove($u);
   		}
   		foreach($estimate as $e) {
   			$e->iduser=$user;
   			$this->getRequest()->_em->persist($e);
   		}
		//$this->getRequest()->_em->flush();
   		$this->getRequest()->_em->remove($users);
   		$this->getRequest()->_em->flush();
   		$this->getRequest()->_cache->remove('User');
   		
    	echo json_encode(array(
					"response" => "true",
					"message" => "Suppression effectuée."	    				
		));
    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
   }
   
   public function countrecordsAction(){
    	$total= $this->getRequest()->_em->getRepository('Auth_Model_User')->getCount();  		
		$this->_helper->json->sendJson($total);
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
    }
}

