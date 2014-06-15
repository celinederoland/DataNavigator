<?php
/**
	* Modèle des commentaires du livre d'or
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace JC\LivreOrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
	* Modèle des commentaires du livre d'or
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*
	* @ORM\Table()
	* @ORM\Entity(repositoryClass="JC\LivreOrBundle\Entity\CommentaireRepository")
	*/
class Commentaire
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
	 * Texte du commentaire
	 *
	 * @var string
	 *
	 * @ORM\Column(name="contenu", type="text")
	 */
	private $contenu;

	/**
	 * Pseudo choisi par l'auteur
	 *
	 * @var string
	 *
	 * @ORM\Column(name="auteur", type="string", length=255)
	 */
	private $auteur;

	/**
	 * Date à laquelle il a été écrit
	 *
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * Constructeur : définit la date au moment présent
	 *
	 * @param string $auteur : nom de l'auteur du commentaire
	 */
	public function __construct($auteur = NULL)
	{
		$this -> date = new \Datetime;
		if ($auteur != NULL) { $this -> setAuteur($auteur); }
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
	 * Set contenu
	 *
	 * @param string $contenu
	 * @return Commentaire
	 */
	public function setContenu($contenu)
	{
		$this->contenu = $contenu;

		return $this;
	}

	/**
	 * Get contenu
	 *
	 * @return string 
	 */
	public function getContenu()
	{
		return $this->contenu;
	}

	/**
	 * Set auteur
	 *
	 * @param string $auteur
	 * @return Commentaire
	 */
	public function setAuteur($auteur)
	{
		$this->auteur = $auteur;

		return $this;
	}

	/**
	 * Get auteur
	 *
	 * @return string 
	 */
	public function getAuteur()
	{
		return $this->auteur;
	}

	/**
	 * Set date
	 *
	 * @param \DateTime $date
	 * @return Commentaire
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
}
