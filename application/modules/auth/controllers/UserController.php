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
    	$this->_helper->layout()->disableLayout();
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
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setRender('add');
        
        $response = false;    
    	$form = new Auth_Form_User;    	
		var_dump("Action Add");
    	if($this->getRequest()->isPost())
    	{
			var_dump('Post Data');
            $data = $this->_request->getPost();
            var_dump($data);
			if($form->isValid($data))
            {      	
                # check for existing email
                $accountExist = $this->getRequest()->_em->getRepository('Auth_Model_User')->findBy(array('emailuser' => (string)$data['emailuser']));
                $idUser = 0;
                if(count($accountExist) == 0)
                {
                	//$group = $this->getRequest()->_em->getRepository('Auth_Model_Usergroup')->find($data['idgroup']);
                	
                    $entity = new Auth_Model_User;
            
                    
                    $entity->emailuser = $data['emailuser'];
					$entity->firstname_user = $data['firstnameuser'];
					$entity->lastname_user = $data['lastnameuser'];
					$entity->login_user = $data['loginuser'];
					//$entity->password_user = $data['pwduser'];
					$entity->rank_user = $data['rankuser'];
					$entity->isActive_user = $data['statususer'];
					$entity->dateregister_user=date("Y-m-d h:i:s");
//                  $entity->pwduser = $data['pwduser'];
                   
                    $entity->setPassword($data['pwduser'], $this->getRequest()->_registry->config->auth->hash);
                    
                	
                    
                	$this->getRequest()->_em->persist($entity);
                    $this->getRequest()->_em->flush();
                    $this->getRequest()->_cache->remove('User');
                    $response = true;
                    $idUser = $entity->iduser;
                    
                 }
                 else {
                     $response = 'Enregistrement impossible : Cet email existe déjà';
                 }
            }
            else {
    		    $response = $form->getMessages();
    		}
    		
    		$this->_helper->json->sendJson(array('response' => $response, 'idUser' => $idUser));
        }
        
        $this->view->form = $form;
    }
    
	/**
     * default method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
    public function updateAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setRender('form');
        
        $response = false;
        $id = $this->getRequest()->getParam('id');
        $entity = $this->getRequest()->_em->find('Auth_Model_User', $id);
        
        $form = new Auth_Form_User(array(
        	'entity' => $entity
        ));        
        
        if($this->getRequest()->isPost())
        {
        	# get params
        	$data = $this->getRequest()->getPost();
        	
        	if($form->isValid($data))
        	{
        	    # check for existing email
        	    $accountExist = $this->getRequest()->_em->getRepository('Auth_Model_User')->findByEmail_user((string) $data['emailuser']);
        	    if(count($accountExist) == 0 || count($accountExist) == 1 && $accountExist[0]->getIduser() == $entity->iduser)
        	    {
	        	    //$group = $this->getRequest()->_em->getRepository('Auth_Model_Usergroup')->find($data['idgroup']);
	        	    
		        	
					$entity->emailuser = $data['emailuser'];
					
					$entity->roleuser = 'PRO';
					
					if(!empty($data['pwduser'])){
						$entity->setPassword($data['pwduser'], $this->getRequest()->_registry->config->auth->hash);
					}
				    
					$date = new Zend_Date;
					
		        	
		        	$this->getRequest()->_em->persist($entity);
		        	$this->getRequest()->_em->flush();
		        	$this->getRequest()->_cache->remove('User');
		        	$response = true;
        	    }
        	    else {
                    $response = 'Enregistrement impossible : Cet email existe déjà';
                }        	   	 
        	}
        	else {
        		$response = $form->getMessages();
        	}
        	
        	$this->_helper->json->sendJson(array('response' => $response));
        }
        
        $dataform = $entity->toArray();
        $dataform["idgroup"]  = $entity->idgroup->idgroup;
        $dataform["namegroupAutocp"] = $entity->idgroup->namegroup;
        $form->populate($dataform);
         
        $this->view->form = $form;
    }
    
	/**
     * default method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
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

