<?php

namespace Sources\GettyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sources\GettyBundle\Entity\GettyFormateur;
use Symfony\Component\HttpFoundation\Response;

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
		$GettyFormateur = new GettyFormateur();
		$jsonresult = $GettyFormateur -> fabriqueGraphe(substr($mot,1,-1),$limite);

		//On envoie la réponse
		return new Response($jsonresult);
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
}
