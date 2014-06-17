<?php

namespace JC\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BddTestCase extends WebTestCase
{
	protected $manager;

	public function __construct() 
	{
		$kernel = static::createKernel();
		$kernel -> boot();
		$this -> manager = $kernel -> getContainer() -> get('doctrine.orm.entity_manager');
	}

	public function adminConnection($client)
	{
		$crawler = $client -> request('GET', '/fr/login');

		$form = $crawler -> selectButton('_submit') -> form();
		$form['_username'] = 'admin';
		$form['_password'] = 'adminpass';
		$crawler = $client -> submit($form);

		$crawler = $client -> followRedirect();
		return $crawler;
	}

	public function lambdaConnection($client)
	{
		$crawler = $client -> request('GET', '/fr/login');

		$form = $crawler -> selectButton('_submit') -> form();
		$form['_username'] = 'lambda';
		$form['_password'] = 'lambda';
		$crawler = $client -> submit($form);

		$crawler = $client -> followRedirect();
		return $crawler;
	}

	public function utilisateurConnection($client)
	{
		$crawler = $client -> request('GET', '/fr/login');

		$form = $crawler -> selectButton('_submit') -> form();
		$form['_username'] = 'testeur';
		$form['_password'] = 'test';
		$crawler = $client -> submit($form);

		$crawler = $client -> followRedirect();
		return $crawler;
	}

}
