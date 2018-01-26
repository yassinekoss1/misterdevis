<?php


use Doctrine\ORM\Mapping as ORM;


/**
 * Class Auth_Model_AlarmeMaison
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    26/01/18
 *
 * @Table(name="qualif_alarme_maison")
 * @Entity(repositoryClass="Auth_Model_AlarmeMaisonRepository")
 */
class Auth_Model_AlarmeMaison {
  
  /**
   * @var integer $id_qualif_alarme_maison
   *
   * @Column(name="ID_QUALIF_ALARME_MAISON", type="integer", nullable=false)
   * @Id
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $id_qualif_alarme_maison;
  
  
  /**
   * @var string $type_travaux
   *
   * @Column(name="TYPE_TRAVAUX", type="string", length=200, nullable=false)
   */
  private $type_travaux;
  
  
  /**
   * @var string $type_alarme
   *
   * @Column(name="TYPE_ALARME", type="string", length=200, nullable=false)
   */
  private $type_alarme;
  
  
  /**
   * @var string $systeme_alarme
   *
   * @Column(name="SYSTEME_ALARME", type="string", length=200, nullable=false)
   */
  private $systeme_alarme;
  
  
  /**
   * @var string $nbre_piece
   *
   * @Column(name="NBRE_PIECE", type="string", length=200, nullable=false)
   */
  private $nbre_piece;
  
  
  /**
   * @var string $nbre_fenetre
   *
   * @Column(name="NBRE_FENETRE", type="string", length=200, nullable=false)
   */
  private $nbre_fenetre;
  
  /**
   * @var \Auth_Model_Demandedevis $id_demande
   *
   * @ManyToOne(targetEntity="Auth_Model_Demandedevis")
   * @JoinColumns({
   *   @JoinColumn(name="ID_DEMANDE", referencedColumnName="ID_DEMANDE")
   * })
   */
  private $id_demande;
  
  
  /**
   * @param $attr
   * @param $val
   */
  public function __set( $attr, $val ) {
    
    $this->$attr = $val;
  }
  
  /**
   * @param $attr
   *
   * @return mixed
   */
  public function __get( $attr ) {
    
    return $this->$attr;
  }
  
  /**
   * @return array
   */
  public function toArray() {
    
    return get_object_vars( $this );
  }
  
  /**
   * @return int
   */
  public function getIdQualifAlarmeMaison() {
    
    return $this->id_qualif_alarme_maison;
  }
  
  /**
   * @param int $id_qualif_alarme_maison
   */
  public function setIdQualifAlarmeMaison( $id_qualif_alarme_maison ) {
    
    $this->id_qualif_alarme_maison = $id_qualif_alarme_maison;
  }
  
  /**
   * @return string
   */
  public function getTypeTravaux() {
    
    return $this->type_travaux;
  }
  
  /**
   * @param string $type_travaux
   */
  public function setTypeTravaux( $type_travaux ) {
    
    $this->type_travaux = $type_travaux;
  }
  
  /**
   * @return string
   */
  public function getTypeAlarme() {
    
    return $this->type_alarme;
  }
  
  /**
   * @param string $type_alarme
   */
  public function setTypeAlarme( $type_alarme ) {
    
    $this->type_alarme = $type_alarme;
  }
  
  /**
   * @return string
   */
  public function getSystemeAlarme() {
    
    return $this->systeme_alarme;
  }
  
  /**
   * @param string $systeme_alarme
   */
  public function setSystemeAlarme( $systeme_alarme ) {
    
    $this->systeme_alarme = $systeme_alarme;
  }
  
  /**
   * @return string
   */
  public function getNbrePiece() {
    
    return $this->nbre_piece;
  }
  
  /**
   * @param string $nbre_piece
   */
  public function setNbrePiece( $nbre_piece ) {
    
    $this->nbre_piece = $nbre_piece;
  }
  
  /**
   * @return string
   */
  public function getNbreFenetre() {
    
    return $this->nbre_fenetre;
  }
  
  /**
   * @param string $nbre_fenetre
   */
  public function setNbreFenetre( $nbre_fenetre ) {
    
    $this->nbre_fenetre = $nbre_fenetre;
  }
  
  /**
   * @return \Auth_Model_Demandedevis
   */
  public function getIdDemande() {
    
    return $this->id_demande;
  }
  
  /**
   * @param \Auth_Model_Demandedevis $id_demande
   */
  public function setIdDemande( $id_demande ) {
    
    $this->id_demande = $id_demande;
  }
  
  
}
