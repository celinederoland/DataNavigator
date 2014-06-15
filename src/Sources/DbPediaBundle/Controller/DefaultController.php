<?php
/**
	* Controleur pour les pages du fouineur DbPedia
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/

namespace Sources\DbPediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sources\DbPediaBundle\Entity\DBFormateur;

/**
	* Controleur pour les pages du fouineur DbPedia
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
	 * @todo Améliorer le paramétrage (regarder du côté des relations)
	 * @return Réponse http
	*/
	public function jsonAction($mot,$relations,$limite)
	{

		//La requête sparql
		$sparql = 
'
SELECT DISTINCT * WHERE 
{
 ?sujet rdfs:label "'.ucfirst($mot).'"@en .
 ?sujet ?property ?objet .
 ?objet ?property2 ?objet2 .
 ?objet2 ?property3 ?objet3 .
 FILTER NOT EXISTS { 
  ?sujet owl:sameAs ?objet .  
 }
 FILTER NOT EXISTS { 
  ?objet owl:sameAs ?objet2 . 
 }
 FILTER NOT EXISTS { 
  ?objet2 owl:sameAs ?objet3 .
 }
} LIMIT '.$limite.'
';
		//L'adresse du moteur sur lequel on doit réaliser cette requête
		$searchUrl = 'http://dbpedia.org/sparql?'
				.'query='.urlencode($sparql)
				.'&format=json';
		//On utilise CURL pour effectuer la requête
		$curl_session = curl_init();
		curl_setopt($curl_session,CURLOPT_URL,$searchUrl);
		curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($curl_session);
		curl_close($curl_session);

		//La requête renvoie une chaine de caractère, dont la partie 'results'->'bindings' correspond aux résultats
		$tableau = json_decode($response,true);
		$resultats = $tableau['results']['bindings'];

		//On utilise le formateur du modèle, dont le rôle est de transformer le résultat fourni par le moteur en un json au format générique.
		$DbFormateur = new DBFormateur();
		$jsoncommun = $DbFormateur -> transformer($resultats);

		//On transforme le tableau en chaine de caractère json
		$json = json_encode($jsoncommun);

		//On envoie la réponse
		return new Response($json);
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
		$text = '{"source":"dbpedia","limite":'.$limite.', "relations":['.$relations.'], "mot":['.$mot.']}';
		return new Response($text);
	}

	/**
	 * Renvoie un fichier json indiquant l'ensemble des relations disponibles dans la source dbpedia.
	 *
	 * @todo cette fonction est bidon
	 * @return HttpResponse json contenant la liste des relations
	*/
	public function jsonrelationsAction() //testée par phpunit
	{
		$tab = array(
			'owl',
			'rdfs'
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
		$mot = 'Horse';
		//L'adresse du moteur sur lequel on doit réaliser cette requête
		$searchUrl = "http://en.wikipedia.org/wiki/" . $mot;
		//On utilise CURL pour effectuer la requête
		$curl_session = curl_init();
		curl_setopt($curl_session,CURLOPT_URL,$searchUrl);
		curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($curl_session);
		curl_close($curl_session);


		preg_match('#<body .*>(.*)</body>#sU', $response, $matches);

		return new Response('<p><a href="http://en.wikipedia.org/wiki/'.$mot.'">source : http://en.wikipedia.org/wiki/'.$mot.'</a></p>'.$matches[1]);
	}

}
