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
	* @return HttpResponse script javascript
	* @todo améliorer cette vue (elle est un peu bidon pour le moment, juste pour tester le relais)
	*/
	public function jsonAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:JsonRep.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue json formatée en graphe (partie cliente de l'application)
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	*/
	public function jsonGraphAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:JsonGraphRep.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue json formatée en arbre (partie cliente de l'application)
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	*/
	public function jsonTreeAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:JsonTreeRep.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue bubble
	* 
	* @return HttpResponse script javascript
	*/
	public function bubbleAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:bubble.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue indented
	* 
	* @return HttpResponse script javascript
	*/
	public function indentedAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:indented.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue force
	* 
	* @return HttpResponse script javascript
	*/
	public function forceAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:force.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue radial
	* 
	* @return HttpResponse script javascript
	*/
	public function radialAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:radial.js.twig', array('data' => $data));
	}

/**
	* Appelle la vue matrice
	* 
	* @return HttpResponse script javascript
	* @todo Radial A FAIRE
	*/
	public function matriceAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:matrice.js.twig', array('data' => $data));
	}

}
