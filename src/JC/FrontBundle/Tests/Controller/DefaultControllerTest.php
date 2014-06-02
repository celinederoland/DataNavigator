<?php

namespace JC\FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/');
		$this->assertTrue($crawler->filter('html:contains("Relations")')->count() > 0,'accueil du site en panne');
	}

	public function testJSTest()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/tests');
		$this->assertTrue($crawler->filter('html:contains("Exécution des tests de l\'application")')->count() > 0,'testeur javascript en panne');
	}
}
