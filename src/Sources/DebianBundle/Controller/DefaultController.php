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

use Sources\DebianBundle\Entity\DebianFormateur;

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
	 * @return Réponse http
	*/
	public function jsonAction($mot,$relations,$limite)
	{
		$DebianFormateur = new DebianFormateur();
		$jsonresult = $DebianFormateur -> fabriqueGraphe($mot,$limite);

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
			'depend'
		);
		$text = json_encode($tab);
		return new Response($text);
	}


	/**
	 * Renvoie un morceau de code html à insérer dans le cadre "infos"
	 *
	 * @param string $mot : Le mot sur lequel on a demandé de l'information
	 * @return HttpResponse
	*/
	public function fenetreAction($mot)
	{
		$url = 'https://packages.debian.org/wheezy/'.$mot;
		$curlSession = curl_init();

		curl_setopt($curlSession, CURLOPT_URL, $url);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curlSession);
		preg_match('#<div id="pdesc" >(.*)</div>#sU', $result, $matchespar);
		preg_match('#<h1>(.*)</h1>#sU', $result, $matchestitre);
		return new Response('<p><a href="https://packages.debian.org/wheezy/'.$mot.'">source : https://packages.debian.org/wheezy/'.$mot.'</a></p>'.$matchestitre[0].$matchespar[1]);
	}
}
