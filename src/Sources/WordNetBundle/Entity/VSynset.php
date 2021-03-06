<?php
/**
	* Modèle des synsets de type verbe
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
	* Modèle des synsets de type verbe
	*
	* rappel : un synset est un ensemble de mots synonymes les uns des autres.
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*
	* @ORM\Table()
	* @ORM\Entity(repositoryClass="Sources\WordNetBundle\Entity\VSynsetRepository")
	*/
class VSynset
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
	 * définition commune à tous les mots du même synset
	 *
	 * @var string
	 *
	 * @ORM\Column(name="definition", type="text")
	 */
	private $definition;

	/**
	 * liste des mots du synset
	 *
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\Mot",mappedBy="vsynsets")
	*/
	private $mots;

	/**
	* liste des antonyms 
	*
	* contraires 
	* Relation ManyToMany entre des VSynsets
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset")
	* @ORM\JoinTable(name="vantonyms")
	*/
	private $antonyms;

	/**
	* liste des troponyms 
	*
	* Relation de généralisation (ex: Communicate est troponym de Talk) 
	* Relation ManyToMany entre des VSynsets
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset",inversedBy="hyponyms")
	* @ORM\JoinTable(name="vtroponyms")
	*/
	private $troponyms;

	/**
	* liste des hyponyms 
	*
	* Relation de spécialisation (ex: Talk est hyponym de Communicate) 
	* Relation inverse de Troponym
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset",mappedBy="troponyms")
	*/
	private $hyponyms;

	/**
	* liste des entails 
	*
	* Relation de nécessité, d'inclusion (ex: Pour respirer il faut obligatoirement expirer (entre autres)) 
	* Relation ManyToMany entre VSynsets
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset",inversedBy="holonyms")
	* @ORM\JoinTable(name="ventails")
	*/
	private $entails;

	/**
	* liste des holonyms 
	*
	* Relation est inclus dans (ex: expirer est obligatoire pour respirer) 
	* Relation inverse de Entails
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset",mappedBy="entails")
	*/
	private $holonyms;

	/**
	* liste des causes 
	*
	* Relation de conséquence logique (ex: une personne enseigne implique que d'autres personnes apprennent) 
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset",inversedBy="consequences")
	* @ORM\JoinTable(name="vcauses")
	*/
	private $causes;

	/**
	* liste des consequences 
	*
	* Relation de conséquence logique (ex: une personne apprend, c'est parce qu'une autre lui enseigne quelque chose) 
	* Relation inverse de causes
	*
	* @ORM\ManyToMany(targetEntity="Sources\WordNetBundle\Entity\VSynset",mappedBy="causes")
	*/
	private $consequences;

	/**
	* Constructeur 
	*
	* @param string $wnid l'identificateur trouvé dans les fichiers wordnet, précédé de la lettre V
	* @param string $def la définition trouvée dans les fichiers wordnet
	*/
	public function __construct($wnid,$def)
	{
		$this -> setDefinition($def);
		$this -> setWnid($wnid);
	}

	/**
	 * Quel est le type du synset ? 
	 *
	 * @return string : 'V' pour verbe
	 */
	public function getType()
	{
		return 'V';
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
	 * @return VSynset
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
	 * @return VSynset
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
	 * @return VSynset
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
	 * @param \Sources\WordNetBundle\Entity\VSynset $antonyms
	 * @return VSynset
	 */
	public function addAntonym(\Sources\WordNetBundle\Entity\VSynset $antonyms)
	{
		$this->antonyms[] = $antonyms;

		return $this;
	}

	/**
	 * Remove antonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $antonyms
	 */
	public function removeAntonym(\Sources\WordNetBundle\Entity\VSynset $antonyms)
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
	 * Add troponyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $troponyms
	 * @return VSynset
	 */
	public function addTroponym(\Sources\WordNetBundle\Entity\VSynset $troponyms)
	{
		$this->troponyms[] = $troponyms;

		return $this;
	}

	/**
	 * Remove troponyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $troponyms
	 */
	public function removeTroponym(\Sources\WordNetBundle\Entity\VSynset $troponyms)
	{
		$this->troponyms->removeElement($troponyms);
	}

	/**
	 * Get troponyms
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getTroponyms()
	{
		return $this->troponyms;
	}

	/**
	 * Add hyponyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $hyponyms
	 * @return VSynset
	 */
	public function addHyponym(\Sources\WordNetBundle\Entity\VSynset $hyponyms)
	{
		$this->hyponyms[] = $hyponyms;

		return $this;
	}

	/**
	 * Remove hyponyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $hyponyms
	 */
	public function removeHyponym(\Sources\WordNetBundle\Entity\VSynset $hyponyms)
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
	 * Add entails
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $entails
	 * @return VSynset
	 */
	public function addEntail(\Sources\WordNetBundle\Entity\VSynset $entails)
	{
		$this->entails[] = $entails;

		return $this;
	}

	/**
	 * Remove entails
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $entails
	 */
	public function removeEntail(\Sources\WordNetBundle\Entity\VSynset $entails)
	{
		$this->entails->removeElement($entails);
	}

	/**
	 * Get entails
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getEntails()
	{
		return $this->entails;
	}

	/**
	 * Add holonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $holonyms
	 * @return VSynset
	 */
	public function addHolonym(\Sources\WordNetBundle\Entity\VSynset $holonyms)
	{
		$this->holonyms[] = $holonyms;

		return $this;
	}

	/**
	 * Remove holonyms
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $holonyms
	 */
	public function removeHolonym(\Sources\WordNetBundle\Entity\VSynset $holonyms)
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
	 * Add causes
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $causes
	 * @return VSynset
	 */
	public function addCause(\Sources\WordNetBundle\Entity\VSynset $causes)
	{
		$this->causes[] = $causes;

		return $this;
	}

	/**
	 * Remove causes
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $causes
	 */
	public function removeCause(\Sources\WordNetBundle\Entity\VSynset $causes)
	{
		$this->causes->removeElement($causes);
	}

	/**
	 * Get causes
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCauses()
	{
		return $this->causes;
	}

	/**
	 * Add consequences
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $consequences
	 * @return VSynset
	 */
	public function addConsequence(\Sources\WordNetBundle\Entity\VSynset $consequences)
	{
		$this->consequences[] = $consequences;

		return $this;
	}

	/**
	 * Remove consequences
	 *
	 * @param \Sources\WordNetBundle\Entity\VSynset $consequences
	 */
	public function removeConsequence(\Sources\WordNetBundle\Entity\VSynset $consequences)
	{
		$this->consequences->removeElement($consequences);
	}

	/**
	 * Get consequences
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getConsequences()
	{
		return $this->consequences;
	}
}
