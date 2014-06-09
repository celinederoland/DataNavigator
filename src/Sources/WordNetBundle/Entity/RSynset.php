<?php
/**
	* Modèle des synsets de type adverbe
	*
	* rappel : un synset est un ensemble de mots synonymes les uns des autres.
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
namespace Sources\WordNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle des synsets de type adverbe
 *
 * rappel : un synset est un ensemble de mots synonymes les uns des autres.
 *
 * @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
 * @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
 *
 * @version 2.0
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sources\WordNetBundle\Entity\RSynsetRepository")
 */
class RSynset
{
	/**
	 * identification dans la base de données
	 *
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * identification dans la base wordnet
	 *
	 * utile uniquement lors de l'import de la base wordnet
	 *
	 * @var string
	 *
	 * @ORM\Column(name="wnid", type="string", length=10)
	 */
	private $wnid;

	/**
	 * Définition du concept représenté par le synset
	 *
	 * @var string
	 *
	 * @ORM\Column(name="definition", type="text")
	 */
	private $definition;

	/**
	 * Liste des mots appartenant à ce synset
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\Mot",mappedBy="rsynsets")
	 */
	private $mots;

	/**
	 * Liste des antonymes de ce synset
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\RSynset")
	 * @ORM\JoinTable(name="rantonyms")
	 */
	private $antonyms;

	/**
	 * Constructeur
	 *
	 * @param string $wnid : identificateur du synset dans les fichiers textes téléchargés de WordNet
	 * @param string $def : définition du concept représenté par le synset
	 */
	public function __construct($wnid,$def)
	{
		$this -> setDefinition($def);
		$this -> setWnid($wnid);
	}

	/**
	 * Quel est le type du synset ? 
	 *
	 * @return string : 'R' pour adverbe
	 */
	public function getType()
	{
		return 'R';
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
	 * Set wnid
	 *
	 * @param string $wnid
	 * @return RSynset
	 */
	public function setWnid($wnid)
	{
		$this->wnid = $wnid;

		return $this;
	}

	/**
	 * Get wnid
	 *
	 * @return string 
	 */
	public function getWnid()
	{
		return $this->wnid;
	}

	/**
	 * Set definition
	 *
	 * @param string $definition
	 * @return RSynset
	 */
	public function setDefinition($definition)
	{
		$this->definition = $definition;

		return $this;
	}

	/**
	 * Get definition
	 *
	 * @return string 
	 */
	public function getDefinition()
	{
		return $this->definition;
	}

	/**
	 * Add mots
	 *
	 * @param \Sources\WordNetBundle\Entity\Mot $mots
	 * @return RSynset
	 */
	public function addMot(\Sources\WordNetBundle\Entity\Mot $mots)
	{
		$this->mots[] = $mots;

		return $this;
	}

	/**
	 * Remove mots
	 *
	 * @param \Sources\WordNetBundle\Entity\Mot $mots
	 */
	public function removeMot(\Sources\WordNetBundle\Entity\Mot $mots)
	{
		$this->mots->removeElement($mots);
	}

	/**
	 * Get mots
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getMots()
	{
		return $this->mots;
	}

	/**
	 * Add antonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\RSynset $antonyms
	 * @return RSynset
	 */
	public function addAntonym(\Sources\WordNetBundle\Entity\RSynset $antonyms)
	{
		$this->antonyms[] = $antonyms;

		return $this;
	}

	/**
	 * Remove antonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\RSynset $antonyms
	 */
	public function removeAntonym(\Sources\WordNetBundle\Entity\RSynset $antonyms)
	{
		$this->antonyms->removeElement($antonyms);
	}

	/**
	 * Get antonyms
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getAntonyms()
	{
		return $this->antonyms;
	}
}
