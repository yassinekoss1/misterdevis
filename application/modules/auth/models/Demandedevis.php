<?php


use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @Table(name="demande_devis")
 * @Entity(repositoryClass="Auth_Model_DemandedevisRepository")
 */
class Auth_Model_Demandedevis {
  
  /**
   * @var integer $id_demande
   *
   * @Column(name="ID_DEMANDE", type="integer", nullable=false)
   * @Id
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $id_demande;
  
  /**
   * @var string $titre_demande
   *
   * @Column(name="TITRE_DEMANDE", type="string", length=50, nullable=false)
   */
  private $titre_demande;
  
  /**
   * @var string $delai_souhaite
   *
   * @Column(name="DELAI_SOUHAITE", type="string", length=50, nullable=false)
   */
  private $delai_souhaite;
  
  /**
   * @var string $description
   *
   * @Column(name="DESCRIPTION", type="string", length=50, nullable=false)
   */
  private $description;
  
  /**
   * @var string $type_demandeur
   *
   * @Column(name="TYPE_DEMANDEUR", type="string", length=50, nullable=false)
   */
  private $type_demandeur;
  
  
  /**
   * @var string $type_propriete
   *
   * @Column(name="TYPE_PROPRIETE", type="string", length=200, nullable=false)
   */
  private $type_propriete;
  
  /**
   * @var string $type_batiment
   *
   * @Column(name="TYPE_BATIMENT", type="string", length=200, nullable=false)
   */
  private $type_batiment;
  
  /**
   * @var string $budget_approximatif
   *
   * @Column(name="BUDGET_APPROXIMATIF", type="string", length=200, nullable=false)
   */
  private $budget_approximatif;
  
  /**
   * @var string $financement_projet
   *
   * @Column(name="FINANCEMENT_PROJET", type="string", length=200, nullable=false)
   */
  private $financement_projet;
  
  /**
   * @var string $objectif_demande
   *
   * @Column(name="OBJECTIF_DEMANDE", type="string", length=200, nullable=false)
   */
  private $objectif_demande;
  
  /**
   * @var string $prestation_souhaite
   *
   * @Column(name="PRESTATION_SOUHAITE", type="string", length=200, nullable=false)
   */
  private $prestation_souhaite;
  
  /**
   * @var string $indication_complementaire
   *
   * @Column(name="INDICATION_COMPLEMENTAIRE", type="string", length=200, nullable=false)
   */
  private $indication_complementaire;
  
  /**
   * @var string $qualification
   *
   * @Column(name="QUALIFICATION", type="string", length=200, nullable=false)
   */
  private $qualification;
  
  /**
   * @var string $prix_mise_en_ligne
   *
   * @Column(name="PRIX_MISE_EN_LIGNE", type="string", length=200, nullable=false)
   */
  private $prix_mise_en_ligne;
  
  /**
   * @var string $prix_promo
   *
   * @Column(name="PRIX_PROMO", type="string", length=200, nullable=false)
   */
  private $prix_promo;
  
  /**
   * @var string $publier_en_ligne
   *
   * @Column(name="PUBLIER_EN_LIGNE", type="boolean",  nullable=false)
   */
  private $publier_en_ligne;
  
  /**
   * @var string $publier_envoi
   *
   * @Column(name="PUBLIER_ENVOI", type="boolean",  nullable=false)
   */
  private $publier_envoi;
  
  /**
   * @var string $chemin_pdf
   *
   * @Column(name="CHEMIN_PDF", type="string", length=200,  nullable=false)
   */
  private $chemin_pdf;
  
  /**
   * @var string $date_creation
   *
   * @Column(name="DATE_CREATION", type="string", length=200,  nullable=false)
   */
  private $date_creation;
  
  /**
   * @var string $date_publication
   *
   * @Column(name="DATE_PUBLICATION", type="string", length=200,  nullable=false)
   */
  private $date_publication;
  
  /**
   * @var Particulier
   *
   * @ManyToOne(targetEntity="Auth_Model_Particulier")
   * @JoinColumns({
   *   @JoinColumn(name="ID_PARTICULIER", referencedColumnName="ID_PARTICULIER")
   * })
   */
  private $id_particulier;
  
  /**
   * @var Activite
   *
   * @ManyToOne(targetEntity="Auth_Model_Activite")
   * @JoinColumns({
   *   @JoinColumn(name="ID_ACTIVITE", referencedColumnName="ID_ACTIVITE")
   * })
   */
  private $id_activite;
  
  /**
   * @var Chantier
   *
   * @ManyToOne(targetEntity="Auth_Model_Chantier")
   * @JoinColumns({
   *   @JoinColumn(name="ID_CHANTIER", referencedColumnName="ID_CHANTIER")
   * })
   */
  private $id_chantier;
  
  /**
   * @var User
   *
   * @ManyToOne(targetEntity="Auth_Model_User")
   * @JoinColumns({
   *   @JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
   * })
   */
  private $id_user;
  
  
  /**
   * @var integer $vendu
   *
   * @Column(name="VENDU", type="integer", length=1,  nullable=false)
   */
  private $vendu;
  
  
  /**
   * @return the attribute
   */
  public function __set( $attr, $val ) {
    
    $this->$attr = $val;
  }
  
  
  /**
   * @param the attribute
   */
  public function __get( $attr ) {
    
    return $this->$attr;
  }
  
  
  /**
   * @return toArray
   */
  public function toArray() {
    
    return get_object_vars( $this );
  }
  
  
  /**
   * @return the $id_demande
   */
  public function getId_demande() {
    
    return $this->id_demande;
  }
  
  
  /**
   * @return the $titre_demande
   */
  public function getTitre_demande() {
    
    return $this->titre_demande;
  }
  
  
  /**
   * @return the $delai_souhaite
   */
  public function getDelai_souhaite() {
    
    return $this->delai_souhaite;
  }
  
  
  /**
   * @return the $description
   */
  public function getDescription() {
    
    return $this->description;
  }
  
  
  /**
   * @return the $type_demandeur
   */
  public function getType_demandeur() {
    
    return $this->type_demandeur;
  }
  
  
  /**
   * @return the $type_propriete
   */
  public function getType_propriete() {
    
    return $this->type_propriete;
  }
  
  
  /**
   * @return the $type_batiment
   */
  public function getType_batiment() {
    
    return $this->type_batiment;
  }
  
  
  /**
   * @return the $budget_approximatif
   */
  public function getBudget_approximatif() {
    
    return $this->budget_approximatif;
  }
  
  
  /**
   * @return the $financement_projet
   */
  public function getFinancement_projet() {
    
    return $this->financement_projet;
  }
  
  
  /**
   * @return the $objectif_demande
   */
  public function getObjectif_demande() {
    
    return $this->objectif_demande;
  }
  
  
  /**
   * @return the $prestation_souhaite
   */
  public function getPrestation_souhaite() {
    
    return $this->prestation_souhaite;
  }
  
  
  /**
   * @return the $indication_complementaire
   */
  public function getIndication_complementaire() {
    
    return $this->indication_complementaire;
  }
  
  
  /**
   * @return the $qualification
   */
  public function getQualification() {
    
    return $this->qualification;
  }
  
  
  /**
   * @return the $prix_mise_en_ligne
   */
  public function getPrix_mise_en_ligne() {
    
    return $this->prix_mise_en_ligne;
  }
  
  
  /**
   * @return the $prix_promo
   */
  public function getPrix_promo() {
    
    return $this->prix_promo;
  }
  
  
  /**
   * @return the $publier_en_ligne
   */
  public function getPublier_en_ligne() {
    
    return $this->publier_en_ligne;
  }
  
  
  /**
   * @return the $publier_envoi
   */
  public function getPublier_envoi() {
    
    return $this->publier_envoi;
  }
  
  
  /**
   * @return the $chemin_pdf
   */
  public function getChemin_pdf() {
    
    return $this->chemin_pdf;
  }
  
  
  /**
   * @return the $date_creation
   */
  public function getDate_creation() {
    
    return $this->date_creation;
  }
  
  
  /**
   * @return the $date_publication
   */
  public function getDate_publication() {
    
    return $this->date_publication;
  }
  
  
  /**
   * @return the $id_particulier
   */
  public function getId_particulier() {
    
    return $this->id_particulier;
  }
  
  
  /**
   * @return the $id_activite
   */
  public function getId_activite() {
    
    return $this->id_activite;
  }
  
  
  /**
   * @return the $id_chantier
   */
  public function getId_chantier() {
    
    return $this->id_chantier;
  }
  
  
  /**
   * @return the $id_user
   */
  public function getId_user() {
    
    return $this->id_user;
  }
  
  
  /**
   * @return int
   */
  public function getVendu() {
    
    return $this->vendu;
  }
  
  
  /**
   * @param integer $id_demande
   */
  public function setId_demande( $id_demande ) {
    
    $this->id_demande = $id_demande;
  }
  
  
  /**
   * @param string $titre_demande
   */
  public function setTitre_demande( $titre_demande ) {
    
    $this->titre_demande = $titre_demande;
  }
  
  
  /**
   * @param string $delai_souhaite
   */
  public function setDelai_souhaite( $delai_souhaite ) {
    
    $this->delai_souhaite = $delai_souhaite;
  }
  
  
  /**
   * @param string $description
   */
  public function setDescription( $description ) {
    
    $this->description = $description;
  }
  
  
  /**
   * @param string $type_demandeur
   */
  public function setType_demandeur( $type_demandeur ) {
    
    $this->type_demandeur = $type_demandeur;
  }
  
  
  /**
   * @param string $type_propriete
   */
  public function setType_propriete( $type_propriete ) {
    
    $this->type_propriete = $type_propriete;
  }
  
  
  /**
   * @param string $type_batiment
   */
  public function setType_batiment( $type_batiment ) {
    
    $this->type_batiment = $type_batiment;
  }
  
  
  /**
   * @param string $budget_approximatif
   */
  public function setBudget_approximatif( $budget_approximatif ) {
    
    $this->budget_approximatif = $budget_approximatif;
  }
  
  
  /**
   * @param string $financement_projet
   */
  public function setFinancement_projet( $financement_projet ) {
    
    $this->financement_projet = $financement_projet;
  }
  
  
  /**
   * @param string $objectif_demande
   */
  public function setObjectif_demande( $objectif_demande ) {
    
    $this->objectif_demande = $objectif_demande;
  }
  
  
  /**
   * @param string $prestation_souhaite
   */
  public function setPrestation_souhaite( $prestation_souhaite ) {
    
    $this->prestation_souhaite = $prestation_souhaite;
  }
  
  
  /**
   * @param string $indication_complementaire
   */
  public function setIndication_complementaire( $indication_complementaire ) {
    
    $this->indication_complementaire = $indication_complementaire;
  }
  
  
  /**
   * @param string $qualification
   */
  public function setQualification( $qualification ) {
    
    $this->qualification = $qualification;
  }
  
  
  /**
   * @param string $prix_mise_en_ligne
   */
  public function setPrix_mise_en_ligne( $prix_mise_en_ligne ) {
    
    $this->prix_mise_en_ligne = $prix_mise_en_ligne;
  }
  
  
  /**
   * @param string $prix_promo
   */
  public function setPrix_promo( $prix_promo ) {
    
    $this->prix_promo = $prix_promo;
  }
  
  
  /**
   * @param string $publier_en_ligne
   */
  public function setPublier_en_ligne( $publier_en_ligne ) {
    
    $this->publier_en_ligne = $publier_en_ligne;
  }
  
  
  /**
   * @param string $publier_envoi
   */
  public function setPublier_envoi( $publier_envoi ) {
    
    $this->publier_envoi = $publier_envoi;
  }
  
  
  /**
   * @param string $chemin_pdf
   */
  public function setChemin_pdf( $chemin_pdf ) {
    
    $this->chemin_pdf = $chemin_pdf;
  }
  
  
  /**
   * @param string $date_creation
   */
  public function setDate_creation( $date_creation ) {
    
    $this->date_creation = $date_creation;
  }
  
  
  /**
   * @param string $date_publication
   */
  public function setDate_publication( $date_publication ) {
    
    $this->date_publication = $date_publication;
  }
  
  
  /**
   * @param Particulier $id_particulier
   */
  public function setId_particulier( $id_particulier ) {
    
    $this->id_particulier = $id_particulier;
  }
  
  
  /**
   * @param Activite $id_activite
   */
  public function setId_activite( $id_activite ) {
    
    $this->id_activite = $id_activite;
  }
  
  
  /**
   * @param Chantier $id_chantier
   */
  public function setId_chantier( $id_chantier ) {
    
    $this->id_chantier = $id_chantier;
  }
  
  
  /**
   * @param User $id_user
   */
  public function setId_user( $id_user ) {
    
    $this->id_user = $id_user;
  }
  
  /**
   * @param int $vendu
   */
  public function setVendu( $vendu ) {
    
    $this->vendu = $vendu;
  }
  
  
  public function getUrl() {
    
    $baseUrl = $_SERVER['HTTP_HOST'];
    $type    = strtolower( $this->getId_activite()->getLibelle() );
    
    
    return "{$baseUrl}/auth/{$type}/edit/id/{$this->getId_demande()}";
  }
  
  
  public function getRef() {
    
    $type = '';
    switch ( $this->getId_activite()->getLibelle() ) {
      case 'CHAUFFAGE':
        $type = 'CHF';
        break;
      case 'FENETRE':
        $type = 'FEN';
        break;
      case 'SALLE BAIN':
        $type = 'SDB';
        break;
      case 'SAUNA HAMMAM':
        $type = 'SNH';
        break;
      case 'CUISINE':
        $type = 'CUI';
        break;
      case 'PISCINE':
        $type = 'PSC';
        break;
      case 'CLIMATISATION':
        $type = 'CLM';
        break;
      case 'SPA':
        $type = 'SPA';
        break;
    }
    
    return ( $type ? "{$type}-" : "" ) . str_pad( $this->getId_demande(), 6, '0', STR_PAD_LEFT );
  }
  
}
