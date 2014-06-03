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

	public function testMenuAdmin()
	{
		$client = static::createClient();

		//On se log en non admin, on vérifie que le menu n'y est pas
		$crawler = $client->request('GET', '/login');

		$form = $crawler -> selectButton('_submit') -> form();
		$form['_username'] = 'lambda';
		$form['_password'] = 'lambda';
		$crawler = $client -> submit($form);

		$crawler = $client -> followRedirect();

		$this->assertTrue($crawler->filter('html:contains("nav#menuadmin")')->count() == 0,'menu admin accessible à un utilisateur lambda');

		//On se log en admin, on vérifie que le menu y est
		$crawler = $client->request('GET', '/login');

		$form = $crawler -> selectButton('_submit') -> form();
		$form['_username'] = 'admin';
		$form['_password'] = 'adminpass';
		$crawler = $client -> submit($form);

		$crawler = $client -> followRedirect();

		$this->assertTrue($crawler->filter('nav#menuadmin')->count() > 0,'menu admin inaccessible');

	}

	public function testJSTest()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/tests');
		$this->assertTrue($crawler->filter('html:contains("Exécution des tests de l\'application")')->count() > 0,'testeur javascript en panne');
	}
}
