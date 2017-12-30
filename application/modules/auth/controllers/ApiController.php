<?php


class Auth_ApiController extends Zend_Controller_Action {

  public function demandesAction() {

    $em = $this->getRequest()->_em;

    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    $this->getResponse()->setHeader('Content-Type', 'application/json');

    $email = urldecode($this->getRequest()->getPost('email'));

    $artisan = $em->getRepository('Auth_Model_Artisan')->findOneBy(['email_artisan' => $email]);

    if (!$artisan)
      echo json_encode([]);


    else {

      $specialities = $em->getRepository('Auth_Model_Artisan')->getSpecialities($artisan->id_artisan);

      $demandes = $em->getRepository('Auth_Model_Demandedevis')->findAllBy([
        'type'   => $specialities,
        'limit'  => 5,
        'online' => 1,
      ]);


      $resp = array_map(function ($demande) {

        return [
          'titre'       => $demande->getTitre_demande(),
          'type'        => ucfirst(strtolower($demande->getId_activite()->getLibelle())),
          'prix'        => $demande->getPrix_mise_en_ligne(),
          'ref'         => $demande->getRef(),
          'ville'       => $demande->getId_chantier()->getZone()->getVille(),
          'code_postal' => $demande->getId_chantier()->getZone()->getCode(),
        ];

      }, $demandes);

      echo json_encode($resp);
    }


  }
}
