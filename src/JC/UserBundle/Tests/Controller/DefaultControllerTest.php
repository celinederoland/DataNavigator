<?php

namespace JC\UserBundle\Tests\Controller;

use JC\Tests\BddTestCase;

class DefaultControllerTest extends BddTestCase
{

	public function testLogin()
	{
		$client = static::createClient();

		$crawler = $this -> lambdaConnection($client);

		$this -> assertTrue($crawler -> filter('html:contains("Bienvenue lambda")') -> count() > 0, 'échec login');
	}

	public function testLogout()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/fr/logout');

		$crawler = $client -> followRedirect();

		$this -> assertTrue($crawler -> filter('html:contains("Bienvenue lambda")') -> count() == 0, 'échec logout');
	}

	public function testRegisterSuppr()
	{

		$usr_rep = $this -> manager -> getRepository('JCUserBundle:User'); 
		$client = static::createClient();

		//On compte les utilisateurs
		$cpt_init = count($usr_rep -> findAll());

		//On enregistre un utilisateur
		$crawler = $client -> request('GET', '/fr/register/');

		$form = $crawler -> selectButton('Créer un compte') -> form();
		$form['fos_user_registration_form[email]'] = 'machin@bidule.fr';
		$form['fos_user_registration_form[username]'] = 'machin';
		$form['fos_user_registration_form[plainPassword][first]'] = 'ccc';
		$form['fos_user_registration_form[plainPassword][second]'] = 'ccc';

		$crawler = $client -> submit($form);

		//On recompte et on vérifie qu'il y en a un de plus
		$cpt_after = count($usr_rep -> findAll());

		$this -> assertTrue($crawler -> filter('html:contains("registration.confirmed")') -> count() == 0, 'échec register');
		$this -> assertEquals($cpt_init + 1, $cpt_after, 'échec register');

		//On supprime l'utilisateur créé
		$crawler = $client -> request('GET', '/fr/supprimer');

		//On recompte et on vérifie qu'on est revenus au nombre initial
		$cpt_final = count($usr_rep -> findAll());

		$this -> assertEquals($cpt_init, $cpt_final, 'échec supprimer');
	}
}
