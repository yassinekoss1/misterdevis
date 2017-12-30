<?php
/**
 * Account Repository
 */


use Doctrine\ORM\EntityRepository;


class Auth_Model_ArtisanRepository extends EntityRepository {

  public function findListEmail($activite, $zone) {

    $queryBuilder = $this->_em->createQueryBuilder();

    return $queryBuilder->from($this->getEntityName(), 'a')
      ->from('Auth_Model_Specialiste', 's')
      ->select('DISTINCT a.email_artisan, a.nom_artisan, a.id_zone')
      ->andWhere('a.id_artisan = s.id_artisan')
      ->where('a.id_zone = :zone')
      ->andWhere('s.id_activite = :activite')
      ->setParameter('activite', $activite)
      ->setParameter('zone', $zone)
      ->getQuery()
      ->getResult();
  }


  public function getSpecialities($id) {

    $qb = $this->_em->createQueryBuilder();

    return $qb
      ->from('Auth_Model_Specialiste', 's')
      ->select('ac.libelle as type')
      ->innerJoin('s.artisan', 'a')
      ->innerJoin('s.activite', 'ac')
      ->where('a.id_artisan = :id')
      ->setParameter('id', $id)
      ->getQuery()
      ->getResult();

  }
}
