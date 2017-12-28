<?php
/**
 * Account Repository
 */


use Doctrine\ORM\EntityRepository;


class Auth_Model_ActiviteRepository extends EntityRepository {

  public function getActivitesByGroup($group) {

    $qb = $this->_em->createQueryBuilder();

    return $qb->select('a.id_activite, a.libelle')
      ->from($this->getEntityName(), 'a')
      ->where('a.group=:group')
      ->setParameter('group', $group)
      ->getQuery()
      ->getResult();
  }
}
