<?php
/**
 * Account Repository
 */

use Doctrine\ORM\EntityRepository;
class Auth_Model_AcheterRepository extends EntityRepository
{
   public function saveAchat($artisan,$demande,$mode){
	   
	   $acheter  = new Auth_Model_Acheter;
	   
	   $acheter->id_artisan=$artisan->getId_artisan();
	   $acheter->id_demande=$demande->getId_demande();
	   $acheter->artisan=$artisan;
	   $acheter->demande=$demande;
	   $acheter->mode_paiement=$mode;
	   
	   
	   
	   $this->_em->persist( $acheter );
	   $this->_em->flush();
    
		return $acheter;
	   
   }
}