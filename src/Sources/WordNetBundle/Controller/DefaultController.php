<?php
/**
	* Controleur pour les pages du fouineur WordNet
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Sources\WordNetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
	* Controleur pour les pages du fouineur WordNet
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{

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
		$text = '{"source":"wordnet", "limite":'.$limite.', "relations":['.$relations.'], "mot":'.$mot.'}';
		return new Response($text);
	}

	/**
	 * Renvoie un fichier json indiquant l'ensemble des relations disponibles dans wordnet.
	 *
	 * @return HttpResponse json contenant la liste des relations
	*/
	public function jsonrelationsAction() //testée par phpunit
	{
		$tab = array(
			'derivation',
			'pertainymie',
			'construction',
			'participe_passe',
			'hypernymie',
			'hyponymie',
			'meronymie',
			'holonymie',
			'troponymie',
			'verbe_hyponymie',
			'entailments',
			'antonymie',
			'attribut',
			'cause',
			'consequence',
			'similar',
			'synonymie'
		);
		$text = json_encode($tab);
		return new Response($text);
	}
}
