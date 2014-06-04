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
	public function jsonAction($data)
	{
		return $this -> render('VuesRepresentationsBundle:Representations:JsonRep.js.twig', array('data' => $data));
	}

}
