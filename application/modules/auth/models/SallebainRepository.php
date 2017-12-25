<?php


use Doctrine\ORM\EntityRepository;


/**
 * Class Auth_Model_SallebainRepository
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    24/12/17
 */
class Auth_Model_SallebainRepository extends EntityRepository {

  public function getList() {

    $qb = $this->_em->createQueryBuilder();

    return $qb->from($this->_entityName, 'ch')
      ->select('d.id_demande, d.titre_demande, d.publier_en_ligne, p.nom_particulier, p.prenom_particulier,' .
        'd.date_creation, d.date_publication, c.ville, c.adresse, c.code_postal, u.firstname_user, u.lastname_user,' .
        'a.libelle as categorie, d.prix_mise_en_ligne')
      ->leftJoin('ch.id_demande', 'd')
      ->leftJoin('d.id_particulier', 'p')
      ->leftJoin('d.id_chantier', 'c')
      ->leftJoin('d.id_user', 'u')
      ->leftJoin('d.id_activite', 'a')
      ->where('d.titre_demande IS NOT NULL and d.titre_demande != \'\'')
      ->orderBy('d.date_creation', 'DESC')
      ->getQuery()
      ->getResult();
  }


  public function getNotifications($justCount = false) {

    $select = $justCount
      ? 'count(d.id_demande)'
      : 'd.id_demande,p.nom_particulier,p.prenom_particulier,d.date_creation';

    $query = $this->_em->createQueryBuilder()
      ->from('Auth_Model_Demandedevis', 'd')
      ->select($select)
      ->leftJoin('d.id_particulier', 'p')
      ->leftJoin('d.id_activite', 'a')
      ->where('a.libelle = :activite')
      ->andWhere('(d.titre_demande IS NULL or d.titre_demande = \'\')')
      ->setParameter('activite', 'SALLE BAIN')
      ->orderBy('d.date_creation', 'DESC')
      ->getQuery();

    return $justCount ? $query->getSingleScalarResult() : $query->getResult();

  }


  public function save($id_demande, $data) {

    // Grabing the demande and returning if there is not

    $demande = $this->_em->getRepository('Auth_Model_Demandedevis')->find($id_demande);
    if (!$demande) return false;

    // Populating the demande user
    $user = $this->_em->getRepository('Auth_Model_User')->find($data['id_user']);
    $demande->setId_user($user);

    // Creating a fresh qualification if there isn't any
    $qualification = $this->_em->getRepository($this->_entityName)->findOneBy(['id_demande' => $id_demande]);
    if (!$qualification) $qualification = new Auth_Model_Sallebain();


    // Populating qualificaiton object
    foreach ($data['Sallebain'] as $key => $val) {
      $prop = 'set' . ucfirst($key);
      if (method_exists($qualification, 'set' . ucfirst($key))) {
        $qualification->$prop($val);
      }
    }


    // Populating demande object

    foreach ($data['Demande'] as $key => $val) {
      $prop = 'set' . ucfirst($key);
      if (method_exists($demande, 'set' . ucfirst($key))) {
        $demande->$prop($val);
      }
    }

    $demande->setDate_publication(date('Y-m-d H:i:s'));


    // Populating particulier object

    foreach ($data['Particulier'] as $key => $val) {
      $prop = 'set' . ucfirst($key);
      if (method_exists($demande->getId_particulier(), 'set' . ucfirst($key))) {
        $demande->getId_particulier()->$prop($val);
      }
    }


    // Populating chantier object

    $chantier = $demande->getId_Chantier();
    if (!$chantier) $chantier = new Auth_Model_Chantier();

    foreach ($data['Chantier'] as $key => $val) {
      if ($key === 'id_zone') continue;
      $prop = 'set' . ucfirst($key);
      if (method_exists($chantier, 'set' . ucfirst($key))) {
        $chantier->$prop($val);
      }
    }


    $zone = $this->_em->getRepository('Auth_Model_Zone')->find($data['Chantier']['id_zone']);
    $chantier->setId_zone($zone);


    $this->_em->persist($chantier);
    $this->_em->flush();

    $demande->setId_chantier($chantier);


    // Attaching the qualification to the demande
    $qualification->setId_demande($demande);


    $this->_em->persist($qualification);
    $this->_em->flush();

    return $qualification;
  }

}
