<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @Table(name="qualif_alarme_maison")
 * @Entity(repositoryClass="Auth_Model_AlarmemaisonRepository")
 */
class Auth_Model_Alarmemaison
{
    /**
     * @var integer $id_qualif_maison
     *
     * @Column(name="ID_QUALIF_MAISON", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id_qualif_maison;

    /**
     * @var string $type_alarme
     *
     * @Column(name="TYPE_ALARME", type="string", length=50, nullable=false)
     */
    private $type_alarme;
	
	/**
     * @var string $type_systeme_alarme
     *
     * @Column(name="TYPE_SYSTEME_ALARME", type="string", length=50, nullable=false)
     */
    private $type_systeme_alarme;
	
	/**
     * @var string $nbre_piece
     *
     * @Column(name="NBRE_PIECE", type="string", length=50, nullable=false)
     */
    private $nbre_piece;
	
	/**
     * @var string $nbre_fenetre
     *
     * @Column(name="NBRE_FENETRE", type="string", length=50, nullable=false)
     */
    private $nbre_fenetre;


    /**
     * @var string $type_travaux
     *
     * @Column(name="TYPE_TRAVAUX", type="string", length=200, nullable=false)
     */
    private $type_travaux;

    /**
     * @var Demandedevis
     *
     * @ManyToOne(targetEntity="Auth_Model_Demandedevis")
     * @JoinColumns({
     *   @JoinColumn(name="ID_DEMANDE", referencedColumnName="ID_DEMANDE")
     * })
     */
    private $id_demande;
    
    
	 /**
	 * @return the attribute
	 */
    public function __set($attr, $val)
    {
    	$this->$attr = $val;
    }
    
    /**
	 * @param the attribute
	 */
    public function __get($attr)
    {
    	return $this->$attr;
    }
        
    /**
	 * @return toArray
	 */
 	public function toArray() {
        return get_object_vars($this);
    }
    
	/**
	 * @return the $id_qualif_maison
	 */
	public function getId_qualif_maison() {
		return $this->id_qualif_maison;
	}

	/**
	 * @return the $type_alarme
	 */
	public function getType_alarme() {
		return $this->type_alarme;
	}
	
	/**
	 * @return the $type_systeme_alarme
	 */
	public function getType_systeme_alarme() {
		return $this->type_systeme_alarme;
	}
	
	/**
	 * @return the $nbre_piece
	 */
	public function getNbre_piece() {
		return $this->nbre_piece;
	}
	
	/**
	 * @return the $nbre_fenetre
	 */
	public function getNbre_fenetre() {
		return $this->nbre_fenetre;
	}

	/**
	 * @return the $type_travaux
	 */
	public function getType_travaux() {
		return $this->type_travaux;
	}

	/**
	 * @return the $id_demande
	 */
	public function getId_demande() {
		return $this->id_demande;
	}

	/**
	 * @param integer $id_qualif_maison
	 */
	public function setId_qualif_maison($id_qualif_maison) {
		$this->id_qualif_maison = $id_qualif_maison;
	}

	/**
	 * @param string $type_alarme
	 */
	public function setType_alarme($type_alarme) {
		$this->type_alarme = $type_alarme;
	}
	
	/**
	 * @param string $type_systeme_alarme
	 */
	public function setType_systeme_alarme($type_systeme_alarme) {
		$this->type_systeme_alarme = $type_systeme_alarme;
	}
	
	/**
	 * @param string $nbre_piece
	 */
	public function setNbre_piece($nbre_piece) {
		$this->nbre_piece = $nbre_piece;
	}
	
	/**
	 * @param string $nbre_fenetre
	 */
	public function setNbre_fenetre($nbre_fenetre) {
		$this->nbre_fenetre = $nbre_fenetre;
	}

	/**
	 * @param string $type_travaux
	 */
	public function setType_travaux($type_travaux) {
		$this->type_travaux = $type_travaux;
	}

	/**
	 * @param Demandedevis $id_demande
	 */
	public function setId_demande($id_demande) {
		$this->id_demande = $id_demande;
	}
	

}