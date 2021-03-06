<?php
/**
	* Classe créée pas Symfony pour gérer le bundle
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	*/
namespace JC\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
	* Classe créée pas Symfony pour gérer le bundle
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	*/
class JCUserBundle extends Bundle
{

/**
	* On indique à symfony que JCUserBundle hérite de FOSUserBundle
	*
	* @return String nom du bundle hérité
	*
	*/
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
