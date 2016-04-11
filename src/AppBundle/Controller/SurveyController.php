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
     * @Route("/sondage", name="new-survey")
     */
    public function newSurveyAction(Request $request)
    {
        //On crée un objet sondage
        $survey = $this->getDoctrine()->getRepository('AppBundle:Survey')->findOneBy([]);

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

   

}
