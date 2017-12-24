<?php


/**
 * Class Auth_ChauffageController
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    23/12/17
 */
class Auth_ChauffageController extends Zend_Controller_Action {

  public function indexAction() {

    //$this->_helper->layout()->disableLayout();
    $this->_helper->layout->setLayout('layout_fo_ehcg');
    $em = $this->getRequest()->_em;


    $this->view->demandes = $em->getRepository('Auth_Model_Chauffage')->getList();
  }


  public function notificationAction() {

    // Disabling render and layout to be able to return json
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);


    // Getting the initial counts
    $lastCount = $this->getRequest()->getParam('count') ? (int)$this->getRequest()->getParam('count') : -1;
    $this->view->count = (int)$this->getRequest()->_em->getRepository('Auth_Model_Chauffage')->getNotifications(true);


    // Checcking if there is a change
    while ($this->view->count === 0 || $this->view->count === $lastCount) {
      usleep(10000);
      clearstatcache();
      session_write_close();
      $this->view->count = (int)$this->getRequest()->_em->getRepository('Auth_Model_Chauffage')->getNotifications(true);
    }

    // Fetching the new demandes
    $this->view->notifications = $this->getRequest()->_em->getRepository('Auth_Model_Chauffage')->getNotifications();

    // Preparing data to send back
    $data = [
      'count' => $this->view->count,
      'html'  => $this->view->render('chauffage/notification.phtml'),
    ];

    // Changing the response header content type to json
    $this->_response->setHeader('Content-type', 'application/json');

    echo json_encode($data);

  }


  public function editAction() {

    // If it's an ajax request disable the layout
    if ($this->getRequest()->isXmlHttpRequest()) $this->_helper->layout()->disableLayout();
    else $this->_helper->layout->setLayout('layout_fo_ehcg');

    $id = $this->getRequest()->getParam('id');
    $em = $this->getRequest()->_em;


    // Proccess the posted data;
    if ($this->getRequest()->isPost()) {
      $data = $this->getRequest()->getPost();
      $data['ID_USER'] = unserialize(Zend_Auth::getInstance()->getIdentity())->id_user;
      $em->getRepository('Auth_Model_Chauffage')->save($id, $data);
    }

    // Load demande;
    $demande = $em->getRepository('Auth_Model_Demandedevis')->find($id);

    // Check inf the data is there or redirect to listing
    if (!$demande || $demande->id_activite->libelle !== 'CHAUFFAGE') $this->_redirect('/auth/chauffage');

    // Load qualification
    $qualification = $em->getRepository('Auth_Model_Chauffage')->findOneBy(['id_demande' => $id]);

    // Load zones
    $zones = $em->getRepository('Auth_Model_Zone')->findAll();

    $this->view->demande = $demande;
    $this->view->qualification = $qualification;
    $this->view->zones = $zones;

  }


  public function pdfAction() {

    // Setting up the view to supress rendring
    $em = $this->getRequest()->_em;
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    // Initializing data
    $id = $this->getRequest()->getParam('id');
    $qualification = $em->getRepository('Auth_Model_Chauffage')->findOneBy(['id_demande' => $id]);
    if (!$qualification) $this->_redirect('/auth/chauffage');

    $this->view->qualification = $qualification;
    $this->view->demande = $qualification->id_demande;

    // Fetching the html string from the view
    $html = $this->view->render('shared/pdf.phtml');


    // Initializing the pdf object
    $pdf = new Auth_Controller_Helper_MyPdf('P', 'mm', 'A4', true, 'UTF-8', false);


    // Set document info
    $pdf->SetAuthor('MisterDevis');
    $pdf->SetTitle($this->view->demande->getTitre_demande());


    // Set the page
    $pdf->AddPage();

    $pdf->writeHTML($html);
    $pdf->Output("{$this->view->demande->titre_demande}-" . time() . ".pdf", 'I');
  }


  public function loadfieldsAction() {

    $em = $this->getRequest()->_em;
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    $type = $this->getRequest()->getParam('type');
    $id = $this->getRequest()->getParam('id');

    if (is_readable("{$this->view->getScriptPaths()[0]}chauffage/partials/{$type}.phtml")) {
      $view_path = "chauffage/partials/{$type}.phtml";

      $this->view->qualification = $em->getRepository('Auth_Model_Chauffage')->find($id);
      echo $this->view->render($view_path);
    } else echo '';
  }

}
