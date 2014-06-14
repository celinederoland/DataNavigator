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
	 * fonction json
	 *
	 * Renvoie un fichier json correspondant au format commun établi.
	 * correspondant à une recherche.
	 *
	 * @param string $mot : mot demandé
	 * @param string $relations : liste des relations à prendre en compte
	 * @param integer $limite : niveau de profondeur demandé
	 * @return Réponse http
	 *
	 * @todo : les branches d'une relation données ne s'affichent pas toutes à cause des paramètres de profondeur
	*/
	public function jsonAction($mot,$relations,$limite)
	{
		$manager = $this -> getDoctrine() -> getManager();
		$mrep = $manager -> getRepository('SourcesWordNetBundle:Mot');

		$text = json_encode($mrep -> fabriqueGraphe($mot,$relations,$limite));

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
		if ($relations == '"all"' and $limite == 2)
		{
			$text = '{"noeuds":[{"id":"M129380","nom":"synapse","type":"M"},{"id":"N30198","nom":" the junction between two neurons (axon-to-dendrite) or between a neuron and a muscle; \"nerve impulses cross a synapse through the action of neurotransmitters\" \n","type":"N"}],"relations":["hypernym","groupe_initial"],"graphe":[{"noeud":"M129380","groupe_initial":["N30198"]},{"noeud":"N30198"}]}';
		}
		else { $text = '{"limite":'.$limite.', "relations":['.$relations.'], "mot":['.$mot.']}'; }
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
