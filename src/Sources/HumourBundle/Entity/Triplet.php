<?php
/**
	* Modèle pour les triplets (objet,relation,objet) de la source humour (un objet est en relation avec un objet)
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/

namespace Sources\HumourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modèle pour les triplets (objet,relation,objet) de la source humour (un objet est en relation avec un objet)
 *
 * @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
 * @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
 *
 * @version 2.0
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sources\HumourBundle\Entity\TripletRepository")
 */
class Triplet
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
	 * Premier objet du triplet
	 *
	 * @ORM\ManyToOne(targetEntity="Sources\HumourBundle\Entity\Objet",inversedBy="triplets")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $sujet;

 /**
	 * Relation du triplet
	 *
	 * @ORM\ManyToOne(targetEntity="Sources\HumourBundle\Entity\Relation")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $relation;

 /**
	 * Deuxième objet du triplet
	 *
	 * @ORM\ManyToOne(targetEntity="Sources\HumourBundle\Entity\Objet")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $objet;

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
	 * Set sujet
	 *
	 * @param \Sources\HumourBundle\Entity\Objet $sujet
	 * @return Triplet
	 */
	public function setSujet(\Sources\HumourBundle\Entity\Objet $sujet)
	{
		$this->sujet = $sujet;

		return $this;
	}

	/**
	 * Get sujet
	 *
	 * @return \Sources\HumourBundle\Entity\Objet 
	 */
	public function getSujet()
	{
		return $this->sujet;
	}

	/**
	 * Set relation
	 *
	 * @param \Sources\HumourBundle\Entity\Relation $relation
	 * @return Triplet
	 */
	public function setRelation(\Sources\HumourBundle\Entity\Relation $relation)
	{
		$this->relation = $relation;

		return $this;
	}

	/**
	 * Get relation
	 *
	 * @return \Sources\HumourBundle\Entity\Relation 
	 */
	public function getRelation()
	{
		return $this->relation;
	}

	/**
	 * Set objet
	 *
	 * @param \Sources\HumourBundle\Entity\Objet $objet
	 * @return Triplet
	 */
	public function setObjet(\Sources\HumourBundle\Entity\Objet $objet)
	{
		$this->objet = $objet;

		return $this;
	}

	/**
	 * Get objet
	 *
	 * @return \Sources\HumourBundle\Entity\Objet 
	 */
	public function getObjet()
	{
		return $this->objet;
	}
}
