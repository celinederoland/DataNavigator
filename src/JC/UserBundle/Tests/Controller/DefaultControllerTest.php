<?php

namespace JC\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testIndex()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/hello/Fabien');

		$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
	}

	public function testLogin()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/login');

		$form = $crawler -> selectButton('_submit') -> form();
		$form['_username'] = 'lambda';
		$form['_password'] = 'lambda';
		$crawler = $client -> submit($form);

		$crawler = $client -> followRedirect();

		$this -> assertTrue($crawler -> filter('html:contains("Bienvenue lambda")') -> count() > 0, 'échec login');
	}

	public function testLogout()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/logout');

		$crawler = $client -> followRedirect();

		$this -> assertTrue($crawler -> filter('html:contains("Bienvenue lambda")') -> count() == 0, 'échec logout');
	}
}
