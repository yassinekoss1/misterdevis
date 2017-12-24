<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @Table(name="particulier")
 * @Entity(repositoryClass="Auth_Model_ParticulierRepository")
 */
class Auth_Model_Particulier
{
    /**
     * @var integer $id_particulier
     *
     * @Column(name="ID_PARTICULIER", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id_particulier;

    /**
     * @var string $nom_particulier
     *
     * @Column(name="NOM_PARTICULIER", type="string", length=50, nullable=false)
     */
    private $nom_particulier;
	
	/**
     * @var string $prenom_particulier
     *
     * @Column(name="PRENOM_PARTICULIER", type="string", length=50, nullable=false)
     */
    private $prenom_particulier;
	
	/**
     * @var string $telephone_fixe
     *
     * @Column(name="TELEPHONE_FIXE", type="string", length=50, nullable=false)
     */
    private $telephone_fixe;
	
	/**
     * @var string $telephone_portable
     *
     * @Column(name="TELEPHONE_PORTABLE", type="string", length=50, nullable=false)
     */
    private $telephone_portable;


    /**
     * @var string $civilite
     *
     * @Column(name="CIVILITE", type="string", length=200, nullable=false)
     */
    private $civilite;
	
	/**
     * @var string $email
     *
     * @Column(name="EMAIL", type="string", length=200, nullable=false)
     */
    private $email;
	
	/**
     * @var string $horaireRDV
     *
     * @Column(name="HORAIRERDV", type="string", length=200, nullable=false)
     */
    private $horaireRDV;
   
    
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
	 * @return the $id_particulier
	 */
	public function getId_particulier() {
		return $this->id_particulier;
	}

	/**
	 * @return the $nom_particulier
	 */
	public function getNom_particulier() {
		return $this->nom_particulier;
	}
	
	/**
	 * @return the $prenom_particulier
	 */
	public function getPrenom_particulier() {
		return $this->prenom_particulier;
	}
	
	/**
	 * @return the $telephone_fixe
	 */
	public function getTelephone_fixe() {
		return $this->telephone_fixe;
	}
	
	/**
	 * @return the $telephone_portable
	 */
	public function getTelephone_portable() {
		return $this->telephone_portable;
	}

	/**
	 * @return the $civilite
	 */
	public function getCivilite() {
		return $this->civilite;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * @return the $horaireRDV
	 */
	public function getHoraireRDV() {
		return $this->horaireRDV;
	}

	/**
	 * @param integer $id_particulier
	 */
	public function setId_particulier($id_particulier) {
		$this->id_particulier = $id_particulier;
	}

	/**
	 * @param string $nom_particulier
	 */
	public function setNom_particulier($nom_particulier) {
		$this->nom_particulier = $nom_particulier;
	}
	
	/**
	 * @param string $prenom_particulier
	 */
	public function setPrenom_particulier($prenom_particulier) {
		$this->prenom_particulier = $prenom_particulier;
	}
	
	/**
	 * @param string $telephone_fixe
	 */
	public function setTelephone_fixe($telephone_fixe) {
		$this->telephone_fixe = $telephone_fixe;
	}
	
	/**
	 * @param string $telephone_portable
	 */
	public function setTelephone_portable($telephone_portable) {
		$this->telephone_portable = $telephone_portable;
	}

	/**
	 * @param string $civilite
	 */
	public function setCivilite($civilite) {
		$this->civilite = $civilite;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	
	/**
	 * @param string $horaireRDV
	 */
	public function setHoraireRDV($horaireRDV) {
		$this->horaireRDV = $horaireRDV;
	}
	

}