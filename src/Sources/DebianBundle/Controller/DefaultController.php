<?php
/**
	* Controleur pour les pages du fouineur Debian
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Sources\DebianBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
	* Controleur pour les pages du fouineur Debian
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
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
	 * @todo Améliorer le paramétrage (regarder du côté de la limite)
	 * @return Réponse http
	*/
	public function jsonAction($mot,$relations,$limite)
	{
		$searchUrl = "http://demo4.itpassion.info/crawler.php?target=".substr($mot,1,-1);

		$curlSession = curl_init();

		curl_setopt($curlSession, CURLOPT_URL, $searchUrl);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonresult = curl_exec($curlSession);
		curl_close($curlSession);

		//On envoie la réponse
		return new Response($jsonresult);
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
		$text = '{"source":"debian","limite":'.$limite.', "relations":['.$relations.'], "mot":['.$mot.']}';
		return new Response($text);
	}

	/**
	 * Renvoie un fichier json indiquant l'ensemble des relations disponibles dans la source debian.
	 *
	 * @todo cette fonction est bidon
	 * @return HttpResponse json contenant la liste des relations
	*/
	public function jsonrelationsAction() //testée par phpunit
	{
		$tab = array(
			'depend',
			'seeAlso'
		);
		$text = json_encode($tab);
		return new Response($text);
	}

}
