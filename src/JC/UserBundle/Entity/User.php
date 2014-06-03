<?php
/**
	* Modèle : Entité utilisateur (héritée de FOSUser)
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace JC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Modèle : Entité utilisateur (héritée de FOSUser)
 *
 * @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
 * @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
 *
 * @version = 2.0
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JC\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
	/**
	 * identificateur en bdd
	 *
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;


	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId()
	{
		return $this -> id;
	}
}
