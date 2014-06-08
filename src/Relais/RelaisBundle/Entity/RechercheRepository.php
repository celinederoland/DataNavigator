<?php
/**
	* Modèle : l'objet Recherche représente l'ensemble des paramètres de recherche utilisés à un moment donné par un utilisateur donné
	*
	* This class was generated by the Doctrine ORM. Add your own custom
	* repository methods below.
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Relais\RelaisBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
	* Modèle : l'objet Recherche représente l'ensemble des paramètres de recherche utilisés à un moment donné par un utilisateur donné
	*
	* This class was generated by the Doctrine ORM. Add your own custom
	* repository methods below.
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class RechercheRepository extends EntityRepository
{

/**
	* Donne une collection des recherches effectuées par l'utilisateur, en appliquant certains filtres.
	*
	* @param JC\UserBundle\Entity\User $user : l'utilisateur actuellement connecté
	* @param string $prio : ordre de classement (ex : date-desc,source-asc pour trier par date descendante et source ascendante). On peut trier par date, source, vue, mot.
	* @param string $impose : récupérer seulement certaines valeur (ex: source-dbpedia, mot-horse pour WHERE source=dbpedia and mot=horse)
	* @return array : liste des recherches correspondantes aux filtres passés en paramètre
	*/
	public function trier($user, $prio, $impose)
	{
		$prio = explode(',',$prio);
		foreach($prio as $valeur)
		{
			$binome = explode('-',$valeur);
			$tabprio[$binome[0]] = $binome[1];
		}
		$tabimpose = array('user' => $user);
		if ($impose != 'none')
		{
			$impose = explode(',',$impose);
			foreach($impose as $valeur)
			{
				$binome = explode('-',$valeur);
				$tabimpose[$binome[0]] = $binome[1];
			}
		}
		return $this -> findBy($tabimpose, $tabprio);
	}
}
