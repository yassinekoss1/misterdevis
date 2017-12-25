<?php


/**
 * Class Auth_SallebainController
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    24/12/17
 */
class Auth_SallebainController extends Zend_Controller_Action {

  public function indexAction() {

    $this->_helper->layout->setLayout('layout_fo_ehcg');
    $em = $this->getRequest()->_em;


    $this->view->demandes = $em->getRepository('Auth_Model_Sallebain')->getList();
  }


  public function notificationAction() {

    // Disabling render and layout to be able to return json
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);


    // Getting the initial counts
    $lastCount = $this->getRequest()->getParam('count') ? (int)$this->getRequest()->getParam('count') : -1;
    $this->view->count = (int)$this->getRequest()->_em->getRepository('Auth_Model_Sallebain')->getNotifications(true);


    // Checcking if there is a change
    while ($this->view->count === 0 || $this->view->count === $lastCount) {
      flush();
      usleep(5000);
      clearstatcache();
      session_write_close();
      $this->view->count = (int)$this->getRequest()->_em->getRepository('Auth_Model_Sallebain')->getNotifications(true);
    }

    // Fetching the new demandes
    $this->view->notifications = $this->getRequest()->_em->getRepository('Auth_Model_Sallebain')->getNotifications();

    // Preparing data to send back
    $data = [
      'count' => $this->view->count,
      'html'  => $this->view->render('sallebain/notification.phtml'),
    ];

    // Changing the response header content type to json
    $this->_response->setHeader('Content-type', 'application/json');

    echo json_encode($data);
    flush();

  }


  public function editAction() {

    // If it's an ajax request disable the layout
    if ($this->getRequest()->isXmlHttpRequest()) $this->_helper->layout()->disableLayout();
    else $this->_helper->layout->setLayout('layout_fo_ehcg');

    $id = $this->getRequest()->getParam('id');
    $em = $this->getRequest()->_em;

    // Load demande;
    $demande = $em->getRepository('Auth_Model_Demandedevis')->find($id);

    // Check inf the data is there or redirect to listing
    if (!$demande || $demande->id_activite->libelle !== 'SALLE BAIN') $this->_redirect('/auth/sallebain');


    // Initializing the forms
    $form = new Zend_Form();
    $form->addSubForms([
      'form_demande'     => new Auth_Form_Demande,
      'form_qualif'      => new Auth_Form_Sallebain,
      'form_chantier'    => new Auth_Form_Chantier,
      'form_particulier' => new Auth_Form_Particulier,
    ]);

    // Load zones
    $zones = $em->getRepository('Auth_Model_Zone')->getArray();


    // Load qualification
    $qualification = $em->getRepository('Auth_Model_Sallebain')->findOneBy(['id_demande' => $id]);


    // Set the default values
    $form->form_chantier->id_zone->setMultiOptions($zones);

    $form->setDefaults([
      'Demande'     => $demande ? $demande->toArray() : null,
      'Particulier' => $demande->id_particulier ? $demande->id_particulier->toArray() : null,
      'Chantier'    => $demande->id_chantier ? $demande->id_chantier->toArray() : null,
      'Sallebain'   => $qualification ? $qualification->toArray() : null,
    ]);

    $form->form_chantier->setDefault('id_zone', $demande->id_chantier ? $demande->id_chantier->id_zone->id_zone : '');


    // Proccess the posted data;
    if ($this->getRequest()->isPost()) {
      $data = $this->getRequest()->getPost();
      if ($form->isValid($data)) {

        // Fetching the current user id
        $data['id_user'] = unserialize(Zend_Auth::getInstance()->getIdentity())->id_user;

        // Save the qualification
        $qualification = $em->getRepository('Auth_Model_Sallebain')->save($id, $data);


        // Reset the form values
        $form->setDefaults([
          'Demande'     => $qualification->id_demande ? $qualification->id_demande->toArray() : null,
          'Particulier' => $qualification->id_demande->id_particulier ? $qualification->id_demande->id_particulier->toArray() : null,
          'Chantier'    => $qualification->id_demande ? $qualification->id_demande->id_chantier->toArray() : null,
          'Sallebain'   => $qualification ? $qualification->toArray() : null,
        ]);
        $form->form_chantier->setDefault('id_zone', $qualification->id_demande->id_chantier ? $qualification->id_demande->id_chantier->id_zone->id_zone : '');


      } else

        // If the form is not valid keep the data provided by the user
        $form->setDefaults($data);

    }


    $this->view->form = $form;
    $this->view->id = $id;
    $this->view->qualification = $qualification;

  }


  public function pdfAction() {

    // Setting up the view to supress rendring
    $em = $this->getRequest()->_em;
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    // Initializing data
    $id = $this->getRequest()->getParam('id');
    $qualification = $em->getRepository('Auth_Model_Sallebain')->findOneBy(['id_demande' => $id]);
    if (!$qualification) $this->_redirect('/auth/sallebain');

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
}
