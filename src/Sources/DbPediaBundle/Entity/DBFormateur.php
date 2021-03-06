<?php
/**
	* Modèle pour le traitement d'un résultat DBPEDIA
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
namespace Sources\DbPediaBundle\Entity;

/**
	* Modèle pour le traitement d'un résultat DBPEDIA
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
class DBFormateur
{

	/**
	 * Fabrique un json au format commun correspondant à la recherche demandée
	 *
	 * @param string $resultats : ensemble des résultats (branche obj rel obj rel obj) fournis par la requete sparql
	 * @return string chaine de caractère au format json générique
	*/
	public function transformer($resultats)
	{
		//Enlever toutes les branches dont un des noeuds contient au moins un littéral qui n'est pas écrit en langue anglaise
		foreach ($resultats as $cle => $chaine) //Un résultat est une chaine d'objets liés par des relations
		{
			if ( ($chaine['sujet']['type'] == 'literal' and isset($chaine['sujet']['xml:lang']) and $chaine['sujet']['xml:lang'] != 'en')
				or ($chaine['objet']['type'] == 'literal' and isset($chaine['objet']['xml:lang']) and $chaine['objet']['xml:lang'] != 'en')
				or ($chaine['objet2']['type'] == 'literal' and isset($chaine['objet2']['xml:lang']) and $chaine['objet2']['xml:lang'] != 'en')
				or ($chaine['objet3']['type'] == 'literal' and isset($chaine['objet3']['xml:lang']) and $chaine['objet3']['xml:lang'] != 'en')
			)
			{
				unset($resultats[$cle]);
			}
		}

		//Etablir la liste des noeuds et des relations :

		//Les identifiants des noeuds commenceront à 1
		$id = 1;
		//Ce tableau deviendra la json générique que nous devons renvoyer aux vues
		$jsoncommun = array();
		//Liste des noeuds
		$lnoeuds = array();
		//Liste des relations
		$lrelations = array();

		//On appellera $chaine un tableau associatif contenant les entrées 'sujet', 'property', 'objet', 'property2', 'objet2', 'property3', 'objet3'. Chacune des entrées étant elle même un tableau contenant des informations (et en particulier l'information 'value') sur resp. le sujet, le premier prédicat, l'objet etc.
		foreach ($resultats as $cle => $chaine) //Un résultat est une chaine d'objets liés par des relations
		{
			//On raccourcit les valeurs des noeuds pour transformer les URI en mots intelligibles
			$resultats[$cle]['sujet']['value'] = $this -> raccourcir($chaine['sujet']['value']);
			$resultats[$cle]['property']['value'] = $this -> raccourcir($chaine['property']['value']);
			$resultats[$cle]['objet']['value'] = $this -> raccourcir($chaine['objet']['value']);
			$resultats[$cle]['property2']['value'] = $this -> raccourcir($chaine['property2']['value']);
			$resultats[$cle]['objet2']['value'] = $this -> raccourcir($chaine['objet2']['value']);
			$resultats[$cle]['property3']['value'] = $this -> raccourcir($chaine['property3']['value']);
			$resultats[$cle]['objet3']['value'] = $this -> raccourcir($chaine['objet3']['value']);

			//On enregistre la liste des noeuds et des relations qui interviendront dans le graphe
			$lnoeuds[] = $resultats[$cle]['sujet']['value'];
			$lrelations[] = $resultats[$cle]['property']['value'];
			$lnoeuds[] = $resultats[$cle]['objet']['value'];
			$lrelations[] = $resultats[$cle]['property2']['value'];
			$lnoeuds[] = $resultats[$cle]['objet2']['value'];
			$lrelations[] = $resultats[$cle]['property3']['value'];
			$lnoeuds[] = $resultats[$cle]['objet3']['value'];
		}
		//var_dump($resultats);

		//On élimine les doublons et on attribut des ids à chaque valeur.
		$lnoeuds = array_unique($lnoeuds);
		$idnoeuds = array_flip($lnoeuds);
		$lrelations = array_unique($lrelations);
		$idrelations = array_flip($lrelations);

		//On place la liste de noeuds dans le json générique
		$jsoncommun['noeuds'] = array();
		foreach($lnoeuds as $cle => $valeur)
		{
			$jsoncommun['noeuds'][] = array('id' => (string)$cle, 'nom' => $valeur);
			$jsoncommun['graphe'][$cle] = array('noeud' => (string)$cle);
		}

		//On place la liste des relations dans le json générique
		$jsoncommun['relations'] = array();
		foreach($lrelations as $valeur)
		{
			$jsoncommun['relations'][] = $valeur;
		}
		
		//On inscrit les relations dans la partie du json générique qui code le graphe.
		foreach ($resultats as $cle => $chaine) //Un résultat est une chaine d'objets liés par des relations
		{
			//Mettre en relation sujet et objet par la relation property
			if (!isset($jsoncommun['graphe'][$idnoeuds[$chaine['sujet']['value']]][$chaine['property']['value']]))
			{
				$jsoncommun['graphe'][$idnoeuds[$chaine['sujet']['value']]][$chaine['property']['value']] = array();
			}
			$jsoncommun['graphe'][$idnoeuds[$chaine['sujet']['value']]][$chaine['property']['value']][] = (string)$idnoeuds[$chaine['objet']['value']];
			//Mettre en relation objet et objet2 par la relation property2
			if (!isset($jsoncommun['graphe'][$idnoeuds[$chaine['objet']['value']]][$chaine['property2']['value']]))
			{
				$jsoncommun['graphe'][$idnoeuds[$chaine['objet']['value']]][$chaine['property2']['value']] = array();
			}
			$jsoncommun['graphe'][$idnoeuds[$chaine['objet']['value']]][$chaine['property2']['value']][] = (string)$idnoeuds[$chaine['objet2']['value']];
			//Mettre en relation objet2 et objet3 par la relation property3
			if (!isset($jsoncommun['graphe'][$idnoeuds[$chaine['objet2']['value']]][$chaine['property3']['value']]))
			{
				$jsoncommun['graphe'][$idnoeuds[$chaine['objet2']['value']]][$chaine['property3']['value']] = array();
			}
			$jsoncommun['graphe'][$idnoeuds[$chaine['objet2']['value']]][$chaine['property3']['value']][] = (string)$idnoeuds[$chaine['objet3']['value']];
		}

		//On enlève les id qui ne sont pas attendues dans le jsoncommun
		$jsoncommun['noeuds'] = array_values($jsoncommun['noeuds']);
		$jsoncommun['graphe'] = array_values($jsoncommun['graphe']);

		$jsoncommun = $this -> supprimerDoublons($jsoncommun);

		return $jsoncommun;
	}

	/**
	 * Simplifie les URI des noeuds et des relations
	 *
	 * @param string $chaine : URI d'un noeud ou d'une relation
	 * @return string Nom simplifié du noeud ou de la relation
	*/
	public function raccourcir($chaine)
	{
		$tableau = explode("/",$chaine);
		$chaine = array_pop($tableau);
		$tableau = explode("#",$chaine);
		$chaine = array_pop($tableau);
		$tableau = explode(":",$chaine);
		$chaine = array_pop($tableau);
		return $chaine;
	}

	/**
	 * Enleve les doublons dans le graphe
	 *
	 * @param array $jsoncommun : tableau du jsoncommun
	 * @return array $jsoncommun : tableau du jsoncommun
	*/
	public function supprimerDoublons($jsoncommun)
	{
		// On parcourt le graphe
		foreach ($jsoncommun['graphe'] as $keyGraphe => $valueGraphe)
		{
			$tab = $jsoncommun['graphe'][$keyGraphe];

			// On parcourt les elements du graphe
			foreach ($tab as $keyTab => $valueTab)
			{
				$element = $tab[$keyTab];

				// On verifie si l'element est bien un tableau 
				// pour enlever les doublons
				if(is_array($element) and !empty($element))
				{
					$jsoncommun['graphe'][$keyGraphe][$keyTab] = array_unique($element);
				}
			}
		}
		return $jsoncommun;
	}
}
