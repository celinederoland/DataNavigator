<?php
/**
	* Modèle : l'objet Recherche représente l'ensemble des paramètres de recherche utilisés à un moment donné par un utilisateur donné
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Relais\RelaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
	* Modèle : l'objet Recherche représente l'ensemble des paramètres de recherche utilisés à un moment donné par un utilisateur donné
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	* @ORM\Table()
	* @ORM\Entity(repositoryClass="Relais\RelaisBundle\Entity\RechercheRepository")
	*/
class Recherche
{
	/**
	 * identificateur en base de données
	 *
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * source de données utilisée
	 *
	 * @var string
	 *
	 * @ORM\Column(name="source", type="string", length=255)
	 */
	private $source;

	/**
	 * vue utilisée
	 *
	 * @var string
	 *
	 * @ORM\Column(name="vue", type="string", length=255)
	 */
	private $vue;

	/**
	 * mot recherché
	 *
	 * @var string
	 *
	 * @ORM\Column(name="mot", type="string", length=255)
	 */
	private $mot;

	/**
	 * date à laquelle la recherche a été effectuée
	 *
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * limite définie pour cette recherche
	 *
	 * @var integer
	 *
	 * @ORM\Column(name="limite", type="integer")
	 */
	private $limite;

	/**
	 * liste des relations demandées
	 *
	 * @var array
	 *
	 * @ORM\Column(name="relations", type="array")
	 */
	private $relations;

	/**
	 * l'utilisateur a t'il placé cette recherche en favoris
	 *
	 * @var boolean
	 *
	 * @ORM\Column(name="favorite", type="boolean")
	 */
	private $favorite;

	/**
	 * profil de l'utilisateur ayant lancé cette recherche
	 *
	 * @ORM\ManyToOne(targetEntity="JC\UserBundle\Entity\User", inversedBy="recherches")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * Constructeur : enregistre la date actuelle et ne met pas la recherche en favori
	 *
	 */
	public function __construct()
	{
		$this -> setDate(new \DateTime());
		$this -> setFavorite(false);
	}


	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set source
	 *
	 * @param string $source
	 * @return Recherche
	 */
	public function setSource($source)
	{
		$this->source = $source;

		return $this;
	}

	/**
	 * Get source
	 *
	 * @return string 
	 */
	public function getSource()
	{
		return $this->source;
	}

	/**
	 * Set vue
	 *
	 * @param string $vue
	 * @return Recherche
	 */
	public function setVue($vue)
	{
		$this->vue = $vue;

		return $this;
	}

	/**
	 * Get vue
	 *
	 * @return string 
	 */
	public function getVue()
	{
		return $this->vue;
	}

	/**
	 * Set mot
	 *
	 * @param string $mot
	 * @return Recherche
	 */
	public function setMot($mot)
	{
		$this->mot = $mot;

		return $this;
	}

	/**
	 * Get mot
	 *
	 * @return string 
	 */
	public function getMot()
	{
		return $this->mot;
	}

	/**
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Recherche
	 */
	public function setDate($date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * Get date
	 *
	 * @return \DateTime 
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set limite
	 *
	 * @param integer $limite
	 * @return Recherche
	 */
	public function setLimite($limite)
	{
		$this->limite = $limite;

		return $this;
	}

	/**
	 * Get limite
	 *
	 * @return integer 
	 */
	public function getLimite()
	{
		return $this->limite;
	}

	/**
	 * Set relations
	 *
	 * @param array $relations
	 * @return Recherche
	 */
	public function setRelations($relations)
	{
		$this->relations = $relations;

		return $this;
	}

	/**
	 * Get relations
	 *
	 * @return array 
	 */
	public function getRelations()
	{
		return $this->relations;
	}

	/**
	 * Set favorite
	 *
	 * @param boolean $favorite
	 * @return Recherche
	 */
	public function setFavorite($favorite)
	{
		$this->favorite = $favorite;

		return $this;
	}

	/**
	 * Get favorite
	 *
	 * @return boolean 
	 */
	public function getFavorite()
	{
		return $this->favorite;
	}

	/**
	 * Set user
	 *
	 * @param \JC\UserBundle\Entity\User $user
	 * @return Recherche
	 */
	public function setUser(\JC\UserBundle\Entity\User $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \JC\UserBundle\Entity\User 
	 */
	public function getUser()
	{
		return $this->user;
	}
}
