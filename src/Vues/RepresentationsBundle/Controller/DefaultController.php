<?php
/**
	* Controleur pour les pages des représentations
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Vues\RepresentationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
	* Controleur pour les pages des représentations
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{

/**
	* Appelle la vue json (partie cliente de l'application)
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	* @todo améliorer cette vue (elle est un peu bidon pour le moment, juste pour tester le relais)
	* @todo faire en sorte que les vues puissent mettre à jour le graphe et non le recharger
	*/
	public function jsonAction($data) //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:JsonRep.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue json formatée en graphe (partie cliente de l'application)
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	* @todo Le json affiché dépasse de la page et on ne peut pas scroller pour voir plus bas. Il faut adapter le css pour permettre que le conteneur conteneurpage soit scrollable.
	*/
	public function jsonGraphAction($data) //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:JsonGraphRep.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue bubble
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	* @todo A FAIRE
	*/
	public function bubbleAction($data) //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:bubble.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue indented
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	* @todo A FAIRE
	*/
	public function indentedAction($data) //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:indented.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue force
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	* @todo A FAIRE
	*/
	public function forceAction($data) //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:force.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue radial
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	* @todo A FAIRE
	*/
	public function radialAction($data) //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:radial.js.twig', array('data' => $data));
	}

}
