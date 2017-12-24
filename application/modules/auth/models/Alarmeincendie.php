<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @Table(name="qualif_alarme_incendie")
 * @Entity(repositoryClass="Auth_Model_AlarmeincendieRepository")
 */
class Auth_Model_Alarmeincendie
{
    /**
     * @var integer $id_qualif_incendie
     *
     * @Column(name="ID_QUALIF_INCENDIE", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id_qualif_incendie;

    /**
     * @var string $surface
     *
     * @Column(name="SURFACE", type="string", length=50, nullable=false)
     */
    private $surface;
	
	/**
     * @var string $nbre_piece
     *
     * @Column(name="NBRE_PIECE", type="string", length=50, nullable=false)
     */
    private $nbre_piece;


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
	 * @return the $id_qualif_incendie
	 */
	public function getId_qualif_incendie() {
		return $this->id_qualif_incendie;
	}

	/**
	 * @return the $surface
	 */
	public function getSurface() {
		return $this->surface;
	}
	
	/**
	 * @return the $nbre_piece
	 */
	public function getNbre_piece() {
		return $this->nbre_piece;
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
	 * @param integer $id_qualif_incendie
	 */
	public function setId_qualif_incendie($id_qualif_incendie) {
		$this->id_qualif_incendie = $id_qualif_incendie;
	}

	/**
	 * @param string $surface
	 */
	public function setSurface($surface) {
		$this->surface = $surface;
	}
	
	/**
	 * @param string $nbre_piece
	 */
	public function setNbre_piece($nbre_piece) {
		$this->nbre_piece = $nbre_piece;
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