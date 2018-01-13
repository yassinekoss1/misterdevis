<?php


use Doctrine\ORM\EntityRepository;


/**
 * Class Auth_Model_ZoneRepository
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    25/12/17
 */
class Auth_Model_ZoneRepository extends EntityRepository {
  
  public function getArray() {
    
    $qb   = $this->_em->createQueryBuilder();
    $data = $qb->from( $this->_entityName, 'z' )
               ->select( 'z.id_zone, z.ville' )
               ->getQuery()
               ->getResult( \Doctrine\ORM\Query::HYDRATE_ARRAY );
    
    $results = [];
    
    foreach ( $data as $item ) {
      $results[ $item['id_zone'] ] = $item['ville'];
    }
    
    return $results;
  }
  
  
  public function getSuggessions( $q ) {
    
    $qb = $this->_em->createQueryBuilder();
    
    return $qb->from( $this->getEntityName(), 'z' )
              ->select( 'DISTINCT z.ville, z.code' )
              ->where( 'z.code LIKE :code' )
              ->orWhere( 'z.ville LIKE :code' )
              ->setParameter( 'code', "{$q}%" )
              ->setMaxResults( 20 )
              ->getQuery()
              ->getResult( 2 );
    
  }
}
