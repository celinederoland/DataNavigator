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

	public function testMenuAdmin()
	{
		$client = static::createClient();

		//On se log en non admin, on vérifie que le menu n'y est pas
		$crawler = $this -> lambdaConnection($client);

		$this->assertTrue($crawler->filter('html:contains("nav#menuadmin")')->count() == 0,'menu admin accessible à un utilisateur lambda');

		//On se log en admin, on vérifie que le menu y est
		$crawler = $this -> adminConnection($client);
		$crawler = $client->request('GET', '/en/relais/');

		$this->assertTrue($crawler->filter('nav#menuadmin')->count() > 0,'menu admin inaccessible');

	}

}
