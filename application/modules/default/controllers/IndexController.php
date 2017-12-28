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

    if ($form_id == '2') {
      $activites = $em->getRepository('Auth_Model_Activite')->findBy(['group' => $data['ID_ACTIVITE']]);

      $artisan = new Auth_Model_Artisan;
      $artisan->setPrenom_artisan(urldecode($data['PRENOM_ARTISAN']));
      $artisan->setNom_artisan(urldecode($data['NOM_ARTISAN']));
      $artisan->setRaison_sociale(urldecode($data['RAISON_SOCIALE']));
      $artisan->setCode_postal(urldecode($data['CODE_POSTAL']));
      $artisan->setTelephone_fixe(urldecode($data['TELEPHONE_FIXE']));
      $artisan->setTelephone_portable(urldecode($data['TELEPHONE_PORTABLE']));
      $artisan->setEmail_artisan(urldecode($data['EMAIL_ARTISAN']));
      $artisan->setHoraireRDV(urldecode($data['HORAIRERDV']));


      foreach ($activites as $activite) {
        $artisan->addActivite($activite);
      }

      $em->persist($artisan);
      $em->flush();


    } else if ($form_id == '3') { // A new particulier request

      // Fetch the activite
      $activite = $em->getRepository('Auth_Model_Activite')->find($data['ID_ACTIVITE']);


      // Saving particulier data
      $particulier = new Auth_Model_Particulier;
      $particulier->setNom_particulier(urldecode($data['NOM_PARTICULIER']));
      $particulier->setPrenom_particulier(urldecode($data['PRENOM_PARTICULIER']));
      $particulier->setTelephone_portable(urldecode($data['TELEPHONE_PORTABLE']));
      $particulier->setEmail(urldecode($data['EMAIL']));

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



