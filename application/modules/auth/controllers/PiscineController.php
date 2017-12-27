<?php


class Auth_PiscineController extends Zend_Controller_Action {

  public function indexAction() {

    //$this->_helper->layout()->disableLayout();
    $this->_helper->layout->setLayout('layout_fo_ehcg');

    $listpiscine = $this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findlistpiscine();

    $this->view->listpiscine = $listpiscine;
  }


  public function notificationAction() {

    $lien = [];
    $dataNotif = $this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findNewRowsPiscine();
    $i = 0;
    foreach ($dataNotif as $n) {
      $lien [$i] = '/auth/piscine/edit/id_demande/' . $n[id_demande];
      $i++;
    }

    $totalLastNotif = count($dataNotif);
    //var_dump($dataNotif);
    $this->view->total = $totalLastNotif;
    $this->view->lien = $lien;
    $this->view->lastNotifications = $dataNotif;
    //$this->view->dt = $calcule;
  }


  public function filterAction() {

    $filter = $this->_request->getParam('filter');
    if (!empty ($filter)) {
      $this->view->filtre = $filter;
    }
  }


  public function editAction() {

    $id = $this->getRequest()->getParam('id_demande');
    $this->_helper->layout->setLayout('layout_fo_ehcg');
    //$this->_helper->layout()->disableLayout();

    $demandedevis = $this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findDemandeDevis($id);
    $piscine = $this->getRequest()->_em->getRepository('Auth_Model_Piscine')->findBy(['id_demande' => $id]);
    $zones = $this->getRequest()->_em->getRepository('Auth_Model_Zone')->findAll();
    $this->view->id_demande = $id;
    $this->view->demandedevis = $demandedevis;
    $this->view->entitypiscine = $piscine[0];

    $this->view->zones = $zones;

    if ($this->getRequest()->isPost()) {

      # get params
      $data = $this->getRequest()->getPost();

      $demande = $this->getRequest()->_em->find('Auth_Model_Demandedevis', $id);
      $user = $this->getRequest()->_em->find('Auth_Model_User', unserialize(Zend_Auth::getInstance()->getIdentity())->id_user);
      $zone = $this->getRequest()->_em->find('Auth_Model_Zone', $data['ID_ZONE']);


      //Modification ou ajout du chantier
      if ($demande->id_chantier == null) {
        $chantier = new Auth_Model_Chantier;
      } else {
        $chantier = $this->getRequest()->_em->find('Auth_Model_Chantier', $demande->id_chantier->id_chantier);
      }
      $chantier->adresse = $data['ADRESSE'];
      $chantier->adresse2 = $data['ADRESSE2'];
      $chantier->ville = $data['VILLE'];
      $chantier->code_postal = $data['CODE_POSTAL'];
      $chantier->id_zone = $zone;

      $this->getRequest()->_em->persist($chantier);
      $this->getRequest()->_em->flush();

      $id_chantier = $chantier->id_chantier;

      //Modification du particulier
      $particulier = $this->getRequest()->_em->find('Auth_Model_Particulier', $demande->id_particulier->id_particulier);
      $particulier->nom_particulier = $data['NOM_PARTICULIER'];
      $particulier->prenom_particulier = $data['PRENOM_PARTICULIER'];
      $particulier->telephone_fixe = $data['TELEPHONE_FIXE'];
      $particulier->telephone_portable = $data['TELEPHONE_PORTABLE'];
      $particulier->email = $data["EMAIL"];
      $particulier->horaireRDV = $data['HORAIRERDV'];

      $this->getRequest()->_em->persist($particulier);
      $this->getRequest()->_em->flush();

      $id_particulier = $particulier->id_particulier;

      //Modification de la demande de devis

      $demande->titre_demande = $data['TITRE_DEMANDE'];
      $demande->delai_souhaite = $data['DELAI_SOUHAITE'];
      $demande->description = $data['DESCRIPTION'];
      $demande->type_demandeur = $data['TYPE_DEMANDEUR'];
      $demande->type_propriete = $data['TYPE_PROPRIETE'];
      $demande->type_batiment = $data['TYPE_BATIMENT'];
      $demande->budget_approximatif = $data['BUDGET_APPROXIMATIF'];
      $demande->financement_projet = $data['FINANCEMENT_PROJET'];
      $demande->objectif_demande = $data['OBJECTIF_DEMANDE'];
      $demande->prestation_souhaite = $data['PRESTATION_SOUHAITE'];
      $demande->indication_complementaire = $data['INDICATION_COMPLEMENTAIRE'];
      $demande->qualification = $data['QUALIFICATION'];
      $demande->prix_mise_en_ligne = $data['PRIX_MISE_EN_LIGNE'];
      $demande->prix_promo = $data['PRIX_PROMO'];
      $demande->publier_en_ligne = $data['PUBLIER_EN_LIGNE'];
      $date = new Zend_Date;
      $demande->date_publication = $date->toString('yyyy-MM-dd HH:mm:ss');
      $demande->id_chantier = $chantier;
      $demande->id_user = $user;

      $this->getRequest()->_em->persist($demande);
      $this->getRequest()->_em->flush();

      //Modification du piscine

      if (count($piscine) == 0) {
        $piscine = new Auth_Model_Piscine;
        $piscine->id_demande = $demande;
      } else {
        $piscine = $piscine[0];
      }
      $piscine->type_piscine = $data['TYPE_PISCINE'];
      $piscine->dimension = $data['DIMENSION'];
      $piscine->forme_piscine = $data['FORME_PISCINE'];
      $piscine->securite_piscine = $data['SECURITE_PISCINE'];
      $piscine->type_travaux = $data['TYPE_TRAVAUX'];

      $this->getRequest()->_em->persist($piscine);
      $this->getRequest()->_em->flush();
      //----------------------------------

      //Envoi email si Publier en ligne

      if ($data['PUBLIER_EN_LIGNE'] == 1 && $demande->publier_envoi == 0) {
        $this->sendMail($data['EMAIL'], 'PISCINE', $data['ID_ZONE'], $data['NOM_PARTICULIER'], $piscine->id_qualif_piscine);
        $demande->publier_envoi = 1;
        $this->getRequest()->_em->persist($demande);
        $this->getRequest()->_em->flush();
      }

      $this->_helper->redirector('index', 'piscine', 'auth');

    }

  }


  public function sendMail($email, $activite, $zone, $username, $id_demande) {

    $config = [
      'auth'     => 'login',
      'ssl'      => 'ssl',
      'port'     => '465',
      'username' => 'webonline235@gmail.com',
      'password' => 'nbvc#123',
    ];

    $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

    $mail = new Zend_Mail('utf-8');
    $id_piscine = str_pad($id_demande, 4, "0", STR_PAD_LEFT);
    //Message pour le particulier
    $bodytext = '<table style="background:rgba(128,128,128,0.02)" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td>
                <table  align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td>
                        <div>
                          <table style="background:rgba(128,128,128,0.02)" align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                              </tr>
                              <tr>
                                <td width="190"><br>
                                </td>
                                <td align="center" width="200" valign="top"><img src="http://mister-devis.com/mrdevis_inc/uploads/2017/03/logo_mister_devis-1.png" alt="Mister-devis.com" width="247" height="50" class="CToWUd"></td>
                                <td width="200"><br>
                                </td>
                              </tr>
                              <tr>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div>
                          <table align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td style="padding:36px 48px;background-color:#0184c2;color:#ffffff" colspan="4" align="center" width="500">
                                  <h1 class="m_2322405772741087723m_104912678704188478bigtitle">
                                    Votre demande de devis est publiée en ligne</h1>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding-top:5px;padding-left:20px;padding-right:20px" colspan="4">
                                  <div>
                                    <p>
                                      Bonjour,</p>
                                    <p>
                                      Nous vous informons que votre demande de devis est publiée en ligne. 
									</p>
                                    <p>
                                      les artisans de notre plateforme vont vous contacter si ça entre de leur intérêt.</p>
                                    <h2>
                                      Demande N°: PSC-' . $id_piscine . ':</h2>
                                  </div>
                                  <div>
                                    &nbsp;<i>A très bientôt</i></div>
                                  <div>
                                    <p>
                                      L\'équipe <a href="http://mister-devis.com" target="_blank">mister-devis.com</a></p>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding:0 48px 48px 48px;border:0;color:#0184c2;font-family:Arial;font-size:12px;line-height:125%;text-align:center" colspan="4" valign="middle">
                                  <br>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>';

    $mail->setBodyHtml($bodytext);
    $mail->setFrom('webonline235@gmail.com', 'Mister Devis');
    $mail->addTo($email, $username);
    $mail->setSubject('Votre demande est publiée en ligne');
    $mail->send($transport);

    //Message pour les artisans
    $activite = $this->getRequest()->_em->getRepository('Auth_Model_Activite')->findBy(['libelle' => $activite]);
    $idactivite = $activite[0]->id_activite;

    $artisans = $this->getRequest()->_em->getRepository('Auth_Model_Artisan')->findListEmail($idactivite, $zone);


    $bodytext = '<table style="background:rgba(128,128,128,0.02)" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td>
                <table  align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td>
                        <div>
                          <table style="background:rgba(128,128,128,0.02)" align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                              </tr>
                              <tr>
                                <td width="190"><br>
                                </td>
                                <td align="center" width="200" valign="top"><img src="http://mister-devis.com/mrdevis_inc/uploads/2017/03/logo_mister_devis-1.png" alt="Mister-devis.com" width="247" height="50" class="CToWUd"></td>
                                <td width="200"><br>
                                </td>
                              </tr>
                              <tr>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                                <td width="200"><br>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div>
                          <table align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td style="padding:36px 48px;background-color:#0184c2;color:#ffffff" colspan="4" align="center" width="500">
                                  <h1 class="m_2322405772741087723m_104912678704188478bigtitle">
                                    Une nouvelle demande de devis a été mise en ligne</h1>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding-top:5px;padding-left:20px;padding-right:20px" colspan="4">
                                  <div>
                                    <p>
                                      Bonjour,</p>
                                    <p>
                                      Nous vous informons qu\'une nouvelle demande de devis concernant votre activité et votre zone d\'intervention a été publiée dans la plateforme.. 
									</p>
                                    <p>
                                       Vous pouvez la consulter dans votre espace pro.</p>
        
                                  </div>
                                  <div>
                                    &nbsp;<i>A très bientôt</i></div>
                                  <div>
                                    <p>
                                      L\'équipe <a href="http://mister-devis.com" target="_blank">mister-devis.com</a></p>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding:0 48px 48px 48px;border:0;color:#0184c2;font-family:Arial;font-size:12px;line-height:125%;text-align:center" colspan="4" valign="middle">
                                  <br>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>';

    foreach ($artisans as $a) {
      $email = $a['email_artisan'];
      $username = $a['nom_artisan'];

      $mail = new Zend_Mail('utf-8');
      $mail->setBodyHtml($bodytext);
      $mail->setFrom('webonline235@gmail.com', 'Mister Devis');
      $mail->setSubject('Nouvelle Demande de devis');
      $mail->addTo($email, $username);
      $mail->send($transport);
    }


  }


  public function pdfAction() {

    //send data to view
    $id = $this->_getParam("id_demande", 0);

    $demandedevis = $this->getRequest()->_em->getRepository('Auth_Model_Demandedevis')->findDemandeDevis($id);
    $piscine = $this->getRequest()->_em->getRepository('Auth_Model_Piscine')->findBy(['id_demande' => $id]);

    $this->view->demandedevis = $demandedevis[0];
    $this->view->piscine = $piscine[0];


    $pdf = new Auth_Controller_Helper_MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $this->_helper->viewRenderer->setNoRender(true);
    $this->_helper->layout->disableLayout();
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->AddPage();

    //    $pdf->Image("resources_fo_ehcg/img/company_logo.png", 10, 10, 80, 13, '', '', '', false, 300, '', false, false, 1, false, false, false);
    //$date = new Zend_Date;
    //$date=$date->toString('dd/MM/yyyy');
    //$pdf->SetY(15);
    //$pdf->SetX($this->original_lMargin);
    //$pdf->Cell(0, 0, $date, 0, 0, 'R');
    $pdf->SetAutoPageBreak(true, 50);
    $html = $this->view->render("piscine/pdf.phtml");
    $pdf->setX(10);
    $pdf->setY(40);
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

    $namePdf = 'pdf/piscine/fiche_devis_' . $id . '.pdf';
    $pdf->Output($namePdf, 'FI');

    header("Content-disposition: attachment; filename=" . $namePdf . "");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
    header("Content-Type: application/force-download");
    header("Pragma: no-cache");
    header("Expires: 0");

    readfile($namePdf);

  }


}
