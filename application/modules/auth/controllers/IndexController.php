<?php


class Auth_IndexController extends Zend_Controller_Action {

  public function citiesAction() {

    $em = $this->getRequest()->_em;

    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    $this->getResponse()->setHeader('Content-Type', 'application/json');

    $q = $this->getRequest()->getParam('q');

    $data = $em->getRepository('Auth_Model_Zone')->getSuggessions($q);


    echo json_encode($data);
  }
}
