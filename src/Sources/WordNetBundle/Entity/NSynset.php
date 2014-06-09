<?php
/**
	* Modèle des synsets de type nom
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
 * Modèle des synsets de type nom
 *
 * rappel : un synset est un ensemble de mots synonymes les uns des autres.
 *
 * @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
 * @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
 *
 * @version 2.0
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sources\WordNetBundle\Entity\NSynsetRepository")
 */
class NSynset
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
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\Mot",mappedBy="nsynsets")
	 */
	private $mots;

	/**
	 * Liste des antonymes de ce synset
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\NSynset")
	 * @ORM\JoinTable(name="nantonyms")
	 */
	private $antonyms;

	/**
	 * Liste des hypernymes de ce synset (relation de généralisation)
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\NSynset",inversedBy="hyponyms")
	 * @ORM\JoinTable(name="nhypernyms")
	 */
	private $hypernyms;

	/**
	 * Liste des hyponymes de ce synset (relation de spécialisation)
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\NSynset",mappedBy="hypernyms")
	 */
	private $hyponyms;

	/**
	 * Liste des méronymes de ce synset (relation partitive)
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\NSynset",inversedBy="holonyms")
	 * @ORM\JoinTable(name="nmeronyms")
	 */
	private $meronyms;

	/**
	 * Liste des holonymes de ce synset (inverse de la relation partitive)
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\NSynset",mappedBy="meronyms")
	 */
	private $holonyms;

	/**
	 * Liste des attributs de ce synset (relation d'attribut entre nom et adjectif)
	 *
	 * @var \Doctrine\Common\Collections\Collection 
	 *
	 * @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\ASynset",inversedBy="isAttributeOf")
	 * @ORM\JoinTable(name="naattributes")
	 */
	private $hasAttribute;

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
	 * @return string : 'N' pour nom
	 */
	public function getType()
	{
		return 'N';
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
	 * @return NSynset
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
	 * @return NSynset
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
	 * @return NSynset
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
	 * @param \Sources\WordNetBundle\Entity\NSynset $antonyms
	 * @return NSynset
	 */
	public function addAntonym(\Sources\WordNetBundle\Entity\NSynset $antonyms)
	{
			$this->antonyms[] = $antonyms;

			return $this;
	}

	/**
	 * Remove antonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $antonyms
	 */
	public function removeAntonym(\Sources\WordNetBundle\Entity\NSynset $antonyms)
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

	/**
	 * Add hypernyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $hypernyms
	 * @return NSynset
	 */
	public function addHypernym(\Sources\WordNetBundle\Entity\NSynset $hypernyms)
	{
			$this->hypernyms[] = $hypernyms;

			return $this;
	}

	/**
	 * Remove hypernyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $hypernyms
	 */
	public function removeHypernym(\Sources\WordNetBundle\Entity\NSynset $hypernyms)
	{
			$this->hypernyms->removeElement($hypernyms);
	}

	/**
	 * Get hypernyms
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getHypernyms()
	{
			return $this->hypernyms;
	}

	/**
	 * Add hyponyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $hyponyms
	 * @return NSynset
	 */
	public function addHyponym(\Sources\WordNetBundle\Entity\NSynset $hyponyms)
	{
			$this->hyponyms[] = $hyponyms;

			return $this;
	}

	/**
	 * Remove hyponyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $hyponyms
	 */
	public function removeHyponym(\Sources\WordNetBundle\Entity\NSynset $hyponyms)
	{
			$this->hyponyms->removeElement($hyponyms);
	}

	/**
	 * Get hyponyms
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getHyponyms()
	{
			return $this->hyponyms;
	}

	/**
	 * Add meronyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $meronyms
	 * @return NSynset
	 */
	public function addMeronym(\Sources\WordNetBundle\Entity\NSynset $meronyms)
	{
			$this->meronyms[] = $meronyms;

			return $this;
	}

	/**
	 * Remove meronyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $meronyms
	 */
	public function removeMeronym(\Sources\WordNetBundle\Entity\NSynset $meronyms)
	{
			$this->meronyms->removeElement($meronyms);
	}

	/**
	 * Get meronyms
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getMeronyms()
	{
			return $this->meronyms;
	}

	/**
	 * Add holonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $holonyms
	 * @return NSynset
	 */
	public function addHolonym(\Sources\WordNetBundle\Entity\NSynset $holonyms)
	{
			$this->holonyms[] = $holonyms;

			return $this;
	}

	/**
	 * Remove holonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\NSynset $holonyms
	 */
	public function removeHolonym(\Sources\WordNetBundle\Entity\NSynset $holonyms)
	{
			$this->holonyms->removeElement($holonyms);
	}

	/**
	 * Get holonyms
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getHolonyms()
	{
			return $this->holonyms;
	}

	/**
	 * Add hasAttribute
	 *
	 * @param \Sources\WordNetBundle\Entity\ASynset $hasAttribute
	 * @return NSynset
	 */
	public function addHasAttribute(\Sources\WordNetBundle\Entity\ASynset $hasAttribute)
	{
			$this->hasAttribute[] = $hasAttribute;

			return $this;
	}

	/**
	 * Remove hasAttribute
	 *
	 * @param \Sources\WordNetBundle\Entity\ASynset $hasAttribute
	 */
	public function removeHasAttribute(\Sources\WordNetBundle\Entity\ASynset $hasAttribute)
	{
			$this->hasAttribute->removeElement($hasAttribute);
	}

	/**
	 * Get hasAttribute
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getHasAttribute()
	{
			return $this->hasAttribute;
	}
}
