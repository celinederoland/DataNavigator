<?php

namespace JC\FrontBundle\Tests\Controller;

use JC\Tests\BddTestCase;

class DefaultControllerTest extends BddTestCase
{
	public function testIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/');
		$this->assertTrue($crawler->filter('html:contains("Relations")')->count() > 0,'accueil du site en panne');
	}

	public function testMenuAdmin()
	{
		$client = static::createClient();

		//On se log en non admin, on vérifie que le menu n'y est pas
		$crawler = $this -> lambdaConnection($client);

		$this->assertTrue($crawler->filter('html:contains("nav#menuadmin")')->count() == 0,'menu admin accessible à un utilisateur lambda');

		//On se log en admin, on vérifie que le menu y est
		$crawler = $this -> adminConnection($client);

		$this->assertTrue($crawler->filter('nav#menuadmin')->count() > 0,'menu admin inaccessible');

	}

	public function testJSTest()
	{
		$client = static::createClient();

		//On se log en admin
		$crawler = $this -> adminConnection($client);

		//On va sur la page de tests
		$crawler = $client->request('GET', '/admin/fr/tests');
		$this->assertTrue($crawler->filter('html:contains("Exécution des tests de l\'application")')->count() > 0,'testeur javascript en panne');
	}
}
