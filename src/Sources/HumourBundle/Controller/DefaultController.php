<?php
/**
	* Controleur pour les pages du fouineur Humour
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Sources\HumourBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
	* Controleur pour les pages du fouineur Humour
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	* @todo Ajouter les fonctions d'administration et d'affichage de cadre
	*/
class DefaultController extends Controller
{

	/**
	 * fonction json
	 *
	 * Renvoie un fichier json correspondant au format commun établi.
	 * correspondant à une recherche.
	 *
	 * @param string $mot : mot demandé
	 * @param string $relations : liste des relations à prendre en compte
	 * @param integer $limite : niveau de profondeur demandé
	 * @return Réponse http
	*/
	public function jsonAction($mot,$relations,$limite)
	{
		$manager = $this -> getDoctrine() -> getManager();
		$mrep = $manager -> getRepository('SourcesHumourBundle:Objet');
		$rel_rep = $manager -> getRepository('SourcesHumourBundle:Relation');
		$mesrels = $rel_rep -> findAll();
		$allrelations = array();
		foreach($mesrels as $relation)
		{
			$allrelations[] = $relation -> getTitre();
		}

		$text = json_encode($mrep -> fabriqueGraphe(substr($mot,1,-1),substr($relations,1,-1),$allrelations));

		//On retourne le json obtenu
		return new Response($text);
	}

/**
	* Génère un json bidon afin de tester le fonctionnement du relais
	*
	* @todo laisser cette fonction pour l'admin uniquement (à la fin du projet)
	* @param $mot
	* @param $relations
	* @param $limite
	* @return HttpResponse json générique
	*/
	public function jsonbidonAction($mot,$relations,$limite) //Non testée car à enlever
	{
		$text = '{"source":"humour","limite":'.$limite.', "relations":['.$relations.'], "mot":['.$mot.']}';
		return new Response($text);
	}

	/**
	 * Renvoie un fichier json indiquant l'ensemble des relations disponibles dans la source humour.
	 *
	 * @todo cette fonction est bidon
	 * @return HttpResponse json contenant la liste des relations
	*/
	public function jsonrelationsAction() //testée par phpunit
	{
		$manager = $this -> getDoctrine() -> getManager();
		$rel_rep = $manager -> getRepository('SourcesHumourBundle:Relation');
		$relations = $rel_rep -> findAll();
		$tab = array();
		foreach($relations as $relation)
		{
			$tab[] = $relation -> getTitre();
		}
		$text = json_encode($tab);
		return new Response($text);
	}
}
