<?php
/**
 * Account Repository
 */

use Doctrine\ORM\EntityRepository;
class Auth_Model_ZoneRepository extends EntityRepository {

  public function getArray() {

    $qb = $this->_em->createQueryBuilder();
    $data = $qb->from($this->_entityName, 'z')
      ->select('z.id_zone, z.libelle')
      ->getQuery()
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    $results = [];

    foreach($data as $item) $results[$item['id_zone']] = $item['libelle'];

    return $results;
  }
}
