<?php

/**
 * Auth Login Controller
 *
 *
 * @author          Lamari Alaa
 * @package       Auth Module
 *
 */
class Auth_LoginController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
		
    }

    /**
     * initiates before any action is dispatched
     *
     * @param	void
     * @return	void
     */
    public function preDispatch()
    {
        # if the user is logged in, they can not login again
        if (Zend_Auth::getInstance()->hasIdentity()) {
            # redirect login page
            $this->_helper->redirector('dashboard', 'index', 'auth');
            
        }
    }

    /**
     * initiates after any action is dispatched
     *
     * @param	void
     * @return	void
     */
    public function postDispatch()
    {
        parent::postDispatch();
    }

    public function indexAction()
    {
     	if (Zend_Auth::getInstance()->hasIdentity()) {
        	$this->_helper->event->record('logged in',unserialize(Zend_Auth::getInstance()->getIdentity())->iduser);
			$this->_helper->redirector('index', 'dashboard', 'auth');
		}
		
	
        
         # load form
        $this->loginForm = new Auth_Form_Login;
		
		$this->view->form = $this->loginForm;

        $save = $this->authenticate();

        # send to view
        //$this->view->loginForm = $save['form'];
        
       
        
        //$this->_helper->layout()->disableLayout();
		$this->_helper->layout->setLayout ( 'login_fo_ehcg' );
    }
   
    
    /**
     * authentication method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
    public function authenticate ()
    {
    		
        # get form
        $form = $this->loginForm;
        if ($this->_request->isPost()) {
     
            # get params
            
            $data = $this->_request->getPost();
            # check validate form
            if ($form->isValid($data)) {
               
                # attempt to authentication
                $authenticate = new Custom_Auth_Adapter(
                $this->getRequest()->_em->getRepository('Auth_Model_User'),
                $this->getRequest()->_registry->config->auth->hash, $data);
               
                $save = Zend_Auth::getInstance()->authenticate($authenticate);
                 
                 if (Zend_Auth::getInstance()->hasIdentity()) {
                    //$this->_helper->event->record('logged in',unserialize(Zend_Auth::getInstance()->getIdentity())->iduser);
					//$this->_helper->event->removeoldconnexion();
                    $alert = array("logged"=>'Logged in successful');

                    # send to dashboard/user page
                    $this->_helper->redirector('index', 'dashboard', 'auth');

                } else {
                    $alert = array("loggedout"=>'Logged in failed');
                }
                
            } else {
            	//echo 'error';
            	//echo $form->populate($data);
           
            }
        }
        //$this->_helper->viewRenderer->setNoRender();
        // $this->_helper->json->sendJson($save['alert']);
    }

    /**
     * Impersonate method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
    public function impersonateAction()
    {

    }

}
