<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type as Field;
use AppBundle\Entity\Survey;
use AppBundle\Form\SurveyType;

class SurveyController extends Controller
{
	/**
     * @Route("/sondage/numero-{id}", name="new-survey")
     */
    public function newSurveyAction(Request $request, $id)
    {
        //On crée un objet sondage
        $survey = $this->getDoctrine()->getRepository('AppBundle:Survey')->findOneBy(array('id' => $id));

        if($survey == null){
        	//mettre une page d'erreur
        	return $this->redirectToRoute('homepage');
        }
		$form = $this->createForm(SurveyType::class, $survey);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// ... perform some action, such as saving the task to the database
			dump('C\'est bon!');die;
			return $this->redirectToRoute('homepage');
		}
		  
		return $this->render('survey/form.html.twig', array(
			'form' => $form->createView(),
		));
    }

    /**
     * @Route("/creer-sondage", name="add-survey")
     */
     public function addAction(Request $request)
  {
    // On crée un objet Advert
    $survey = new Survey();

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder('form', $survey);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('date',      'date')
      ->add('title',     'text')
      ->add('content',   'textarea')
      ->add('author',    'text')
      ->add('published', 'checkbox')
      ->add('save',      'submit')
    ;
    // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('survey/form.html.twig', array(
      'form' => $form->createView(),
    ));
  }
   

}
