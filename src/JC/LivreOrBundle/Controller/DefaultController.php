<?php
/**
	* Controleur pour les pages du livre d'or
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/

namespace JC\LivreOrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JC\LivreOrBundle\Entity\Commentaire;

/**
	* Controleur pour les pages du livre d'or
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{

/**
 * Création d'un formulaire
 *
 * @param Commentaire $comment
 * @return FormBuilder
 */
	public function formulaire($comment)
	{
		$formBuilder = $this -> createFormBuilder($comment);
		$formBuilder -> add('auteur','text');
		$formBuilder -> add('contenu','textarea');
		if ($this -> get('kernel') -> getEnvironment() != 'test')
		{
			$formBuilder -> add('captcha', 'captcha');
		}
		return $formBuilder;
	}

/**
 * Fonction principale du livre d'or
 *
 * Crée et si besoin enregistre le formulaire d'ajout de commentaire.
 * Demande au modèle tous les commentaires afin de les afficher
 *
 * @return Vue Twig
 */
	public function indexAction()
	{
		$manager = $this -> getDoctrine() -> getManager();
		$request = $this->get('request');

		if ($this -> get('security.context') -> isGranted('ROLE_USER')) 
		{ 
			$comment = new Commentaire($this -> get('security.context') -> getToken() -> getUser() -> getUsername()); 
		}
		else { $comment = new Commentaire(); }

		$form = $this -> formulaire($comment) -> getForm();
		if ($request->getMethod() == 'POST') 
		{
			$form -> bind($request);
			if ($form->isValid()) 
			{
				$manager -> persist($comment);
				$manager -> flush();
			}
		}

		$form = $form -> createView();

		$com_rep = $manager -> getRepository('JCLivreOrBundle:Commentaire');
		$comments = $com_rep -> findBy(array(),array('date'=>'desc'));
		return $this -> render('JCLivreOrBundle:Default:index.html.twig', array('form' => $form, 'comments' => $comments));
	}

/**
 * Fonction de suppression
 *
 * Demande au modèle d'effacer le commentaire sélectionné
 * Appelle la vue administrateur
 *
 * @param integer $id : identificateur du commentaire à supprimer
 * @return Vue Twig
 */
	public function supprimerAction($id)
	{
		$manager = $this -> getDoctrine() -> getManager();
		$com_rep = $manager -> getRepository('JCLivreOrBundle:Commentaire');
		$comment = $com_rep -> find($id);
		$manager -> remove($comment);
		$manager -> flush();
		//$comments = $com_rep -> findBy(array(),array('date'=>'desc'));
		return $this -> indexAction();
	}

}
