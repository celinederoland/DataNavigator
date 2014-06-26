<?php

namespace Relais\RelaisBundle\Tests\Controller;

use JC\Tests\BddTestCase;

class DefaultControllerTest extends BddTestCase
{
	public function testBidon() { $this -> assertTrue(true); }

	public function testIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/en/relais/');
		//var_dump($client -> getResponse() -> getContent());
		$this->assertTrue($crawler->filter('html:contains("Relations")')->count() > 0,'accueil du site en panne');
	}

/*	public function testMenuAdmin()
	{
		$client = static::createClient();

		//On se log en non admin, on vérifie que le menu n'y est pas
		$crawler = $this -> lambdaConnection($client);

		$this->assertTrue($crawler->filter('html:contains("nav#menuadmin")')->count() == 0,'menu admin accessible à un utilisateur lambda');

		//On se log en admin, on vérifie que le menu y est
		$crawler = $this -> adminConnection($client);
		$crawler = $client -> request('GET', '/en/relais/');

		$this -> assertTrue($crawler -> filter('nav#menuadmin') -> count() > 0,'menu admin inaccessible');

	}*/

	public function testHistorique()
	{

		$recherche_rep = $this -> manager -> getRepository('RelaisRelaisBundle:Recherche'); 
		$cpt_init = count($recherche_rep -> findAll());

		$client = static::createClient();
		$crawler = $this -> lambdaConnection($client);

		$crawler = $client -> request(
			'POST', 
			'/en/relais/historique',
			array(
				"form" => array(
					"mot" => '"machin"',
					"source" => 'debian',
					"vue" => 'radial',
					"limite" => 3,
					"relations" => array()
				)
			)
		);
		//var_dump($client -> getResponse() -> getContent());
		$cpt_after = count($recherche_rep -> findAll());

		$this -> assertEquals($cpt_init + 1, $cpt_after, 'échec enregistrement historique');
	}

	public function testShowHistorique()
	{
		$client = static::createClient();
		$crawler = $this -> utilisateurConnection($client);

		$crawler = $client -> request('GET', '/en/relais/historique/show');

		$this -> assertTrue($crawler -> filter('html:contains(\'08/06/2014\')') -> count() > 0,'problème affichage historique');
	}

	public function testFavori()
	{
		$recherche_rep = $this -> manager -> getRepository('RelaisRelaisBundle:Recherche');

		$client = static::createClient();
		$crawler = $this -> utilisateurConnection($client);

		$crawler = $client -> request('GET', '/en/relais/historique/change/21');

		$fav = $recherche_rep -> find(21) -> getFavorite();
		$this -> assertTrue($fav,'problème mise en favori');
	}

	public function testNoFavori()
	{
		$recherche_rep = $this -> manager -> getRepository('RelaisRelaisBundle:Recherche');

		$client = static::createClient();
		$crawler = $this -> utilisateurConnection($client);

		$crawler = $client -> request('GET', '/en/relais/historique/change/21');

		$nofav = $recherche_rep -> find(21) -> getFavorite();
		$this -> assertFalse($nofav,'problème enlever des favoris');
	}
}
