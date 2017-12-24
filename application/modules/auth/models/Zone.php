<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @Table(name="zone")
 * @Entity(repositoryClass="Auth_Model_ZoneRepository")
 */
class Auth_Model_Zone
{
    /**
     * @var integer $id_zone
     *
     * @Column(name="ID_ZONE", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id_zone;

    /**
     * @var string $libelle
     *
     * @Column(name="LIBELLE", type="string", length=50, nullable=false)
     */
    private $libelle;   
    
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
	 * @return the $id_zone
	 */
	public function getId_zone() {
		return $this->id_zone;
	}

	/**
	 * @return the $libelle
	 */
	public function getLibelle() {
		return $this->libelle;
	}
	

	

	/**
	 * @param integer $id_zone
	 */
	public function setId_zone($id_zone) {
		$this->id_zone = $id_zone;
	}

	/**
	 * @param string $libelle
	 */
	public function setLibelle($libelle) {
		$this->libelle = $libelle;
	}
	

}