<?php
/**
 * Account Repository
 */


use Doctrine\ORM\EntityRepository;


class Auth_Model_DemandedevisRepository extends EntityRepository {
  
  public function findlist() {
    
    $queryBuilder = $this->_em->createQueryBuilder();
    $queryBuilder->from( $this->_entityName, 'd' )
                 ->join( 'd.id_user', 'u' )
                 ->select( 'd.id_demande,p.nom_particulier,p.prenom_particulier,d.titre_demande,d.date_publication,d.date_creation,u.firstname_user,u.lastname_user,d.publier_en_ligne,d.prix_mise_en_ligne,
						a.libelle,z.ville,z.code' )
                 ->leftjoin( 'd.id_particulier', 'p' )
                 ->leftjoin( 'd.id_activite', 'a' )
                 ->leftjoin( 'd.id_chantier', 'c' )
                 ->leftjoin( 'c.zone', 'z' )
                 ->orderBy( 'd.date_creation', 'desc' );
    
    $query = $queryBuilder->getQuery();
    
    return $query->getResult();
  }
  
  
  public function findAllBy( $criteria ) {
    
    $q = $this->createQueryBuilder( 'd' )
              ->innerJoin( 'd.id_activite', 'a' );
    
    if ( $criteria['zone'] ) {
      
      $q->innerJoin( 'd.id_chantier', 'ch' )
        ->andWhere( 'ch.id_zone = :zone' )
        ->setParameter( 'zone', $criteria['zone'] );
    }
    
    if ( $criteria['artisan'] ) {
      $q->leftJoin( 'd.acheteurs', 'ach' )
        ->andWhere( '(ach.id_artisan <> :id_artisan or ach.id_artisan IS NULL)' )
        ->setParameter( 'id_artisan', $criteria['artisan'] );
    }
    
    if ( $criteria['type'] ) {
      $types = array_map( function ( $type ) {
        
        return $type['type'];
      }, $criteria['type'] );
      
      $q->andWhere( "a.libelle IN  (:types)" )->setParameter( 'types', $types );
    }
    
    if ( $criteria['online'] ) {
      $q->andWhere( 'd.publier_en_ligne = 1' );
    }
    
    if ( $criteria['limit'] ) {
      $q->setMaxResults( $criteria['limit'] );
    }
    
    return $q->getQuery()->getResult();
  }
  
  
  public function saveVendu( $id_demande, $vendu ) {
    
    $demande = $this->_em->getRepository( 'Auth_Model_Demandedevis' )->find( $id_demande );
    
    $demande->vendu = $vendu;
    
    $this->_em->persist( $demande );
    $this->_em->flush();
    
    return $demande;
    
  }
}
