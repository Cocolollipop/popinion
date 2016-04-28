<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type as Field;
use AppBundle\Entity\Survey;
use AppBundle\Form\SurveyType;
use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;
use AppBundle\Entity\Answer;
use AppBundle\Form\AnswerType;

class SurveyController extends Controller
{
	/**
     * @Route("/sondage/numero-{id}", name="new-survey")
     */
    public function newSurveyAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
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
			$counter = $survey->getCounter();
			$survey->setCounter($counter+1);
			$list = $survey->getQuestions();
			foreach($list as $listAnswers)
			{
				$idAnswer = $listAnswers->getId();
				$answer =$this->getDoctrine()->getRepository('AppBundle:Answer')->findOneBy(array('id' => $idAnswer));
				$vote = $answer->getVote();
				$answer->setVote($vote+1);
                
                
			}
		

		
			$em->flush();
			return $this->redirectToRoute('homepage');
		}
		  
		return $this->render('survey/form.html.twig', array(
			'form' => $form->createView(),
		));
    }

   

}
