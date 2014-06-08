<?php

namespace Relais\RelaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recherche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Relais\RelaisBundle\Entity\RechercheRepository")
 */
class Recherche
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="source", type="string", length=255)
	 */
	private $source;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="vue", type="string", length=255)
	 */
	private $vue;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="mot", type="string", length=255)
	 */
	private $mot;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="limite", type="integer")
	 */
	private $limite;

	/**
	 * @var array
	 *
	 * @ORM\Column(name="relations", type="array")
	 */
	private $relations;


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
}
