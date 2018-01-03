<?php
/**
 * Account Repository
 */


use Doctrine\ORM\EntityRepository;


class Auth_Model_ArtisanRepository extends EntityRepository {
  
  public function findListEmail( $activite, $zone ) {
    
    return $this->createQueryBuilder( 'a' )
                ->innerJoin( 'a.activites', 'ac' )
                ->innerJoin( 'a.chantier', 'ch' )
                ->where( 'ch.id_zone = :zone' )
                ->andWhere( 'ac.id_activite = :activite' )
                ->setParameters( [
                  'zone'     => $zone,
                  'activite' => $activite,
                ] )
                ->getQuery()
                ->getResult( 2 );
  }
  
  
  public function getSpecialities( $id ) {
    
    $qb = $this->_em->createQueryBuilder();
    
    return $qb
      ->from( 'Auth_Model_Specialiste', 's' )
      ->select( 'ac.libelle as type' )
      ->innerJoin( 's.artisan', 'a' )
      ->innerJoin( 's.activite', 'ac' )
      ->where( 'a.id_artisan = :id' )
      ->setParameter( 'id', $id )
      ->getQuery()
      ->getResult();
    
  }
  
  
  public function save( $id = null, $data ) {
    
    
    // Grabing the demande or creating new one
    $artisan = $this->_em->getRepository( 'Auth_Model_Artisan' )->find( $id );
    if ( ! $artisan ) {
      $artisan = new Auth_Model_Artisan;
    }
    
    if ( strlen( $data['Artisan']['pass'] ) ) {
      $artisan->setPass( (string) hash( 'SHA256', $hash . $data['Artisan']['pass'] ) );
    }
    unset( $data['Artisan']['pass'] );
    
    
    // Populating artisan object
    foreach ( $data['Artisan'] as $key => $val ) {
      $prop = 'set' . ucfirst( $key );
      if ( method_exists( $artisan, 'set' . ucfirst( $key ) ) ) {
        $artisan->$prop( $val );
      }
    }
    
    
    $this->deleteActivites( $id );
    
    $activites = array_unique( $data['Artisan']['select_activites'] );
    
    foreach ( $activites as $id ) {
      $activite = $this->_em->getRepository( 'Auth_Model_Activite' )->find( $id );
      if ( $activite ) {
        $artisan->addActivite( $activite );
      }
    }
    
    
    $chantier = $artisan->getChantier();
    if ( ! $chantier ) {
      $chantier = new Auth_Model_Chantier();
    }
    
    $chantier->zone = $this->_em->getRepository( 'Auth_Model_Zone' )->find( $data['Chantier']['id_zone'] );
    
    foreach ( $data['Chantier'] as $key => $val ) {
      if ( $key === 'id_zone' ) {
        continue;
      }
      $prop = 'set' . ucfirst( $key );
      if ( method_exists( $chantier, 'set' . ucfirst( $key ) ) ) {
        $chantier->$prop( $val );
      }
    }
    
    
    $this->_em->persist( $chantier );
    $this->_em->flush();
    
    $artisan->setChantier( $chantier );
    
    
    $this->_em->persist( $artisan );
    $this->_em->flush();
    
    
    return $artisan;
  }
  
  public function deleteActivites( $id ) {
    
    $this->_em->createQueryBuilder()
              ->delete( 'Auth_Model_Specialiste', 's' )
              ->where( 's.id_artisan = :id_artisan' )
              ->setParameter( 'id_artisan', $id )
              ->getQuery()
              ->getResult();
    
    
  }
}
