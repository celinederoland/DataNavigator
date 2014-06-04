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
	* @return HttpResponse json générique
	*/
	public function jsonbidonAction() //Non testée car à enlever
	{
		$text = '{"noeuds":[{"id":"M129380","nom":"synapse","type":"M"},{"id":"N30198","nom":" the junction between two neurons (axon-to-dendrite) or between a neuron and a muscle; \"nerve impulses cross a synapse through the action of neurotransmitters\" \n","type":"N"}],"relations":["hypernym","groupe_initial"],"graphe":[{"noeud":"M129380","groupe_initial":["N30198"]},{"noeud":"N30198"}]}';
		return new Response($text);
	}

}
