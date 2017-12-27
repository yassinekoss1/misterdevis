<?php


/**
 * Default Controller
 *
 * @author          Eddie Jaoude
 * @package         Default Module
 *
 */
class IndexController extends Zend_Controller_Action {

  /**
   * Initialisation method
   *
   * @author           Lamari Alaa
   *
   * @param           void
   *
   * @return           void
   *
   */
  private $_sys_email;


  public function init() {

    $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
    $this->_sys_email = $config->system->email->toArray();
  }


  /**
   * post dispatch method
   *
   * @author          Eddie Jaoude
   *
   * @param           void
   *
   * @return           void
   *
   */
  public function postDispatch() {

    parent::postDispatch();
  }


  /**
   * default method
   *
   * @author           Lamari Alaa
   *
   * @param           void
   *
   * @return           void
   *
   */
  public function indexAction() {

  }


  public function catchAction() {

    $em = $this->getRequest()->_em;

    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    $form_id = $this->getRequest()->getParam('ID_FORM');
    $data = $this->getRequest()->getPost();

    $myfile = fopen(APPLICATION_PATH . "/tmp/newfile.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $data['NOM_PARTICULIER']);
    fclose($myfile);


    $body = '';

    if ($form_id == '2') {

      // $artisan = new Auth_Model_Artisan;
      // $artisan->setPrenom_artisan($data['PRENOM_ARTISAN']);
      // $artisan->setNom_artisan($data['NOM_ARTISAN']);
      // $artisan->setRaison_sociale($data['RAISON_SOCIALE']);
      // $artisan->setCode_postal($data['CODE_POSTAL']);
      // $artisan->setTelephone_fixe($data['TELEPHONE_FIXE']);
      // $artisan->setTelephone_portable($data['TELEPHONE_PORTABLE']);
      // $artisan->setEmail_artisan($data['EMAIL_ARTISAN']);
      // $artisan->setHoraireRDV($data['HORAIRERDV']);
      //
      // $em->presist($artisan);
      // $em->flush();
      //
      // $activites = $em->getRepository('Auth_Model_Activite')->getActivitesByGroup($data['ID_ACTIVITE']);
      //
      // foreach ($activites as $activite) {
      //   $spec = new Auth_Model_Specialiste;
      //   $spec->setId_activite($artisan);
      //   $spec->setId_activite($activite);
      //   $em->presist($spec);
      // }
      //
      // $em->flush();


    } else if ($form_id == '3') { // A new particulier request

      // Fetch the activite
      $activite = $em->getRepository('Auth_Model_Activite')->find($data['ID_ACTIVITE']);


      // Saving particulier data
      $particulier = new Auth_Model_Particulier;
      $particulier->setNom_particulier($data['NOM_PARTICULIER']);
      $particulier->setPrenom_particulier($data['PRENOM_PARTICULIER']);
      $particulier->setTelephone_portable($data['TELEPHONE_PORTABLE']);
      $particulier->setEmail($data['EMAIL']);

      $em->persist($particulier);
      $em->flush();

      // Saving demande data
      $demande = new Auth_Model_Demandedevis;
      $demande->setId_particulier($particulier);
      $demande->setId_activite($activite);
      $demande->setDate_creation(date('Y-m-d H:i:s'));
      $em->persist($demande);
      $em->flush();


      $ops = $em->getRepository('Auth_Model_User')->getOperatorsEmails();


      // Notify the operators

      foreach ($ops as $op) {
        $this->view->demande = $demande;
        $this->view->particulir = $particulier;
        $this->view->ref = $demande->getRef();
        $this->view->demande_url = $demande->getUrl();
        $mail = new Zend_Mail('utf-8');
        $mail->setSubject('Une nouvelle demande');
        $mail->setFrom($this->_sys_email['address'], $this->_sys_email['name']);
        $mail->setBodyHtml($this->view->render('shared/new_demande_mail.phtml'));

        $mail->addTo($op['emailuser'], $op['lastname_user']);


        $mail->send();
      }

    }
  }

}

