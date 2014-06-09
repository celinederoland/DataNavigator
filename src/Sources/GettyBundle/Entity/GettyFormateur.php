<?php
/**
	* Modèle pour le traitement d'un résultat Getty
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
namespace Sources\GettyBundle\Entity;

/**
	* Modèle pour le traitement d'un résultat Getty
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
class GettyFormateur
{

	/**
	 * Fabrique un json au format commun correspondant à la recherche demandée
	 *
	 * @return string chaine de caractère au format json générique
	*/
	public function fabriqueGraphe($mot,$limite)
	{

		$jsoncommun = '{"noeuds":[{"id":"M129380","nom":"synapse","type":"M"},{"id":"N30198","nom":" the junction between two neurons (axon-to-dendrite) or between a neuron and a muscle; \"nerve impulses cross a synapse through the action of neurotransmitters\" \n","type":"N"}],"relations":["hypernym","groupe_initial"],"graphe":[{"noeud":"M129380","groupe_initial":["N30198"]},{"noeud":"N30198"}]}';
		return $jsoncommun;
	}

}
