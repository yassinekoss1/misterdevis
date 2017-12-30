<?php


/**
 * Class Auth_PiscineController
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    24/12/17
 */
class Auth_PiscineController extends Zend_Controller_Action {

  private $_sys_email;


  public function init() {

    $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
    $this->_sys_email = $config->system->email->toArray();
  }


  public function indexAction() {

    $this->_helper->layout->setLayout('layout_fo_ehcg');
    $em = $this->getRequest()->_em;


    $this->view->demandes = $em->getRepository('Auth_Model_Piscine')->getList();
  }


  public function notificationAction() {

    // Disabling render and layout to be able to return json
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);


    // Getting the initial counts
    $lastCount = $this->getRequest()->getParam('count') ? (int)$this->getRequest()->getParam('count') : -1;
    $this->view->count = (int)$this->getRequest()->_em->getRepository('Auth_Model_Piscine')->getNotifications(true);


    // Checcking if there is a change
    while ($this->view->count === 0 || $this->view->count === $lastCount) {
      flush();
      usleep(5000);
      clearstatcache();
      session_write_close();
      $this->view->count = (int)$this->getRequest()->_em->getRepository('Auth_Model_Piscine')->getNotifications(true);
    }

    // Fetching the new demandes
    $this->view->notifications = $this->getRequest()->_em->getRepository('Auth_Model_Piscine')->getNotifications();

    // Preparing data to send back
    $data = [
      'count' => $this->view->count,
      'html'  => $this->view->render('piscine/notification.phtml'),
    ];

    // Changing the response header content type to json
    $this->_response->setHeader('Content-type', 'application/json');

    echo json_encode($data);
    flush();

  }


  private function sendEmailNotifications($demande) {

    $em = $this->getRequest()->_em;


    // Fetching the artisans concerned with this demande
    $artisans = $em->getRepository('Auth_Model_Artisan')->findListEmail(
      $demande->getId_activite()->getId_activite(),
      $demande->getId_chantier()->getId_zone()
    );

    $data = [
      'artisans'     => $artisans,
      'particuliers' => [
        [
          'nom_particulier'   => $demande->getId_particulier()->getNom_particulier(),
          'email_particulier' => $demande->getId_particulier()->getEmail(),
        ],
      ],
      'ref'          => $demande->getRef(),
    ];

    $data_string = json_encode($data);


    $ch = curl_init('0.0.0.0:3000');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'Authorization: ' . md5('erratbi'),
      'Content-Length: ' . strlen($data_string),
    ]);

    curl_exec($ch);
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
    if (!$demande || $demande->id_activite->libelle !== 'PISCINE') $this->_redirect('/auth/piscine');

    // Initializing the forms
    $form = new Zend_Form();
    $form->addSubForms([
      'form_demande'     => new Auth_Form_Demande,
      'form_qualif'      => new Auth_Form_Piscine,
      'form_chantier'    => new Auth_Form_Chantier,
      'form_particulier' => new Auth_Form_Particulier,
    ]);

    $form->form_chantier->code_postal->setAttrib('autocomplete', 'off');

    // Load qualification
    $qualification = $em->getRepository('Auth_Model_Piscine')->findOneBy(['id_demande' => $id]);

    $form->setDefaults([
      'Demande'     => $demande ? $demande->toArray() : null,
      'Particulier' => $demande->id_particulier ? $demande->id_particulier->toArray() : null,
      'Chantier'    => $demande->id_chantier ? $demande->id_chantier->toArray() : null,
      'Piscine'     => $qualification ? $qualification->toArray() : null,
    ]);

    $form->form_chantier->setDefaults(['code_postal' => $demande->id_chantier->zone->code]);

    // Proccess the posted data;
    if ($this->getRequest()->isPost()) {
      $data = $this->getRequest()->getPost();
      $zone = $em->getRepository('Auth_Model_Zone')->findOneBy(['code' => $data['Chantier']['code_postal']]);

      $valid = $form->isValid($data);

      if (!$zone)
        $form->form_chantier->code_postal->setAttribs(['class' => 'has-error']);


      if ($valid && $zone !== null) {

        // We will send an email
        $sendEmail = false;

        $data['Chantier']['id_zone'] = $zone->getId_zone();
        if ($data['Demande']['publier_en_ligne']) {
          $sendEmail = !((bool)$demande->getPublier_envoi());
          $data['Demande']['publier_envoi'] = true;
        }


        // Fetching the current user id
        $data['id_user'] = unserialize(Zend_Auth::getInstance()->getIdentity())->id_user;


        // Save the qualification
        $qualification = $em->getRepository('Auth_Model_Piscine')->save($id, $data);

        if ($qualification) {


          // Send an email if there hasn't been one sent
          if ($sendEmail)
            $this->sendEmailNotifications($demande);


          $_SESSION['flash'] = "La mise à jour a été effectuée avec success";
          $this->getResponse()->setRedirect('/auth/piscine');

        }


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
    $qualification = $em->getRepository('Auth_Model_Piscine')->findOneBy(['id_demande' => $id]);
    if (!$qualification) $this->_redirect('/auth/piscine');

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
    $pdf->Output("{$this->view->demande->titre_demande}-" . time() . ".pdf", 'D');
  }
}
