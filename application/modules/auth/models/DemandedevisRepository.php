<?php
/**
 * Account Repository
 */

use Doctrine\ORM\EntityRepository;
class Auth_Model_DemandedevisRepository extends EntityRepository
{
   public function findlist()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->from($this->_entityName, 'd')
                ->join('d.id_user', 'u')
                ->select('d.id_demande,p.nom_particulier,p.prenom_particulier,d.titre_demande,d.date_publication,d.date_creation,u.firstname_user,u.lastname_user,d.publier_en_ligne,d.prix_mise_en_ligne,
						a.libelle,c.ville,c.code_postal')
                ->leftjoin('d.id_particulier', 'p')
				->leftjoin('d.id_activite', 'a')
				->leftjoin('d.id_chantier', 'c')
                ->orderBy('d.date_creation', 'desc');

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
	
	public function findNewRowsPiscine()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->from($this->_entityName, 'd')
                ->select('d.id_demande,p.nom_particulier,p.prenom_particulier,d.date_creation')
                ->leftjoin('d.id_particulier', 'p')
				->leftjoin('d.id_activite', 'a')
				->where('a.libelle = :activite')
                ->setParameter('activite', 'PISCINE')
				->andWhere('d.titre_demande is Null')
				->andWhere('d.qualification is Null')
                ->orderBy('d.date_creation', 'desc');

        $query = $queryBuilder->getQuery();
		//return $queryBuilder->getQuery()->getSQL();
        return $query->getResult();
    }
	
	public function findDemandeDevis($id_demande){
		
		$queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->from($this->_entityName, 'd')
                ->join('d.id_particulier', 'p')
                ->select('d.id_demande,p.nom_particulier,p.prenom_particulier,p.telephone_fixe,p.telephone_portable,p.email,p.horaireRDV,
						d.titre_demande,d.delai_souhaite,d.description,d.type_demandeur,d.type_propriete,d.type_batiment,d.budget_approximatif,
						d.financement_projet,d.objectif_demande,d.prestation_souhaite,d.indication_complementaire,d.qualification,d.prix_mise_en_ligne,
						d.prix_promo,d.publier_en_ligne,c.adresse,c.adresse2,c.ville,c.code_postal,z.id_zone')
				->leftjoin('d.id_chantier', 'c')
				->leftjoin('c.id_zone', 'z')
                ->Where('d.id_demande=:id')
				->setParameter('id',$id_demande);

        $query = $queryBuilder->getQuery();
        return $query->getResult();
		
	}
}