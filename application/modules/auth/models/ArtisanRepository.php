<?php
/**
 * Account Repository
 */

use Doctrine\ORM\EntityRepository;
class Auth_Model_ArtisanRepository extends EntityRepository
{
   public function findListEmail($activite,$zone)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->from('Auth_Model_Geolocaliser', 'g')
					->from('Auth_Model_Specialiste','s')
					->from('Auth_Model_Artisan','p')
					->select('DISTINCT p.nom_artisan,p.email_artisan,g.id_zone,s.id_activite')
					->Where('p.id_artisan=g.id_artisan')
					->andWhere('p.id_artisan=s.id_artisan')
					->andWhere('s.id_activite=:activite')
					->andWhere('g.id_zone=:zone')
					->setParameter('activite',$activite)
					->setParameter('zone',$zone)
					
					;

        $query = $queryBuilder->getQuery();
		$sql=$query->getSQL();
		//return $sql;
        return $query->getResult();
    }
}