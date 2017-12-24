<?php
/**
 * Auth Logout Controller
 *
 *
 * @author          Lamari Alaa
 * @package       Auth Module
 *
 */
class Auth_LogoutController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author          Lamari Alaa
     * @param           void
     * @return           void
     *
     */
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
        # if the user is not logged in, they can not log out
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            # redirect login page
            $this->_helper->redirector('login', 'index', 'auth');
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
        # record event

        # clears users identity
        Zend_Auth::getInstance()->clearIdentity();
		
		$this->_helper->redirector('login','index', 'auth');

        # display to user

        # redirect
       echo ('vous avez été déconnecté');
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

