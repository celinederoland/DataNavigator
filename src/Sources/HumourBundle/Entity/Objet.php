<?php
/**
	* Modèle pour les objets de la source humour (un objet est en relation avec un objet)
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
namespace Sources\HumourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
	* Modèle pour les objets de la source humour (un objet est en relation avec un objet)
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sources\HumourBundle\Entity\ObjetRepository")
 */
class Objet
{
	/**
	 * Identificateur en base de données
	 *
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * Titre (nom de l'objet en un mot)
	 *
	 * @var string
	 *
	 * @ORM\Column(name="titre", type="string", length=255)
	 */
	private $titre;

	/**
	 * Type de l'objet (Personne, Technologie, Entreprise etc)
	 *
	 * @var string
	 *
	 * @ORM\Column(name="type", type="string", length=255)
	 */
	private $type;

	/**
	 * Description détaillée de l'objet
	 *
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;

	/**
	 * Nom de l'image associée à cet objet
	 *
	 * @var string
	 *
	 * @ORM\Column(name="image", type="string", length=255)
	 */
	private $image;

	/**
	* liste des triplets dont cet objet est le sujet 
	*
	* @ORM\OneToMany(targetEntity="Sources\HumourBundle\Entity\Triplet",mappedBy="sujet")
	*/
	private $triplets;

	/**
	* liste des triplets dont cet objet est l'objet 
	*
	* @ORM\OneToMany(targetEntity="Sources\HumourBundle\Entity\Triplet",mappedBy="objet")
	*/
	private $otriplets;

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
	 * Set titre
	 *
	 * @param string $titre
	 * @return Objet
	 */
	public function setTitre($titre)
	{
		$this->titre = $titre;

		return $this;
	}

	/**
	 * Get titre
	 *
	 * @return string 
	 */
	public function getTitre()
	{
		return $this->titre;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 * @return Objet
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string 
	 */
	public function getDescription()
	{
		return $this->description;
	}
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->triplets = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add triplets
	 *
	 * @param \Sources\HumourBundle\Entity\Triplet $triplets
	 * @return Objet
	 */
	public function addTriplet(\Sources\HumourBundle\Entity\Triplet $triplets)
	{
		$this->triplets[] = $triplets;

		return $this;
	}

	/**
	 * Remove triplets
	 *
	 * @param \Sources\HumourBundle\Entity\Triplet $triplets
	 */
	public function removeTriplet(\Sources\HumourBundle\Entity\Triplet $triplets)
	{
		$this->triplets->removeElement($triplets);
	}

	/**
	 * Get triplets
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getTriplets()
	{
		return $this->triplets;
	}

	/**
	 * Add otriplets
	 *
	 * @param \Sources\HumourBundle\Entity\Triplet $otriplets
	 * @return Objet
	 */
	public function addOtriplet(\Sources\HumourBundle\Entity\Triplet $otriplets)
	{
		$this->otriplets[] = $otriplets;

		return $this;
	}

	/**
	 * Remove otriplets
	 *
	 * @param \Sources\HumourBundle\Entity\Triplet $otriplets
	 */
	public function removeOtriplet(\Sources\HumourBundle\Entity\Triplet $otriplets)
	{
		$this->otriplets->removeElement($otriplets);
	}

	/**
	 * Get otriplets
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getOtriplets()
	{
		return $this->otriplets;
	}

	/**
	 * Get otriplets
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getAlltriplets()
	{
		return array_merge($this->getOtriplets() -> toArray(), $this -> getTriplets() -> toArray());
	}


	/**
	 * Set type
	 *
	 * @param string $type
	 * @return Objet
	 */
	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return string 
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set image
	 *
	 * @param string $image
	 * @return Objet
	 */
	public function setImage($image)
	{
		$this->image = $image;

		return $this;
	}

	/**
	 * Get image
	 *
	 * @return string 
	 */
	public function getImage()
	{
		return $this->image;
	}
}
