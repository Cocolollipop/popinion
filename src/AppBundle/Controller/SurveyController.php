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
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class SurveyController extends Controller
{
	/**
     * @Route("/sondage/numero-{id}", name="new-survey")
     */
    public function newSurveyAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
        //Create an object survey
        $survey = $em->getRepository('AppBundle:Survey')->findOneBy(array('id' => $id));

        if($survey == null){
        	//add an error page
        	return $this->redirectToRoute('homepage');
        }

		$form = $this->createForm(SurveyType::class, $survey);
		$form->handleRequest($request);


		if ($form->isSubmitted() && $form->isValid()) {


			//add a vote
			$counter = $survey->getCounter();
			$counter= $counter+1;
			$survey->setCounter($counter);
			$list = $survey->getQuestions();
		

			foreach($list as $listAnswers)
			{
				$idAnswer = $listAnswers->getId();
				$answer =$this->getDoctrine()->getRepository('AppBundle:Answer')->findOneBy(array('id' => $idAnswer));
				$vote = $answer->getVote();
				$answer->setVote($vote+1);
					$em->persist($answer);
						

			}
			$em->detach($survey);
			$em->flush();
			

			//Redirection
			//NB: Add a message
			return $this->redirectToRoute('homepage');
		} 
		//NB: Add a constraint
		return $this->render('survey/form.html.twig', array(
			'form' => $form->createView(),
		));
    }

	/**
     * @Route("/creer-sondage", name="add-survey")
     */
    public function addSurveyAction(Request $request)
    {

	/**$em = $this->getDoctrine()->getManager();
    $survey = new Survey();
	$form = $this->createForm(SurveyType::class, $survey);
	$form->handleRequest($request);
**/
//2e methode
 $survey = new Survey();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $quest1 = new Question();
        $quest1->name = 'wording1';
        $survey->getQuestions()->add($quest1);
        $answer1 = new Answer();
        $answer1->name = 'wording2';
        $quest1->getAnswers()->add($answer1);
        $answer2 = new Answer();
        $answer2->name = 'wording3';
        $quest1->getAnswers()->add($answer2);

   

        $form = $this->createForm(SurveyType::class, $survey);

        $form->handleRequest($request);


		if ($form->isSubmitted() && $form->isValid())
		 {

				$em = $this->getDoctrine()->getManager();
    			$em->persist($survey);
    			$em->flush();

				return $this->redirectToRoute('homepage');


		}
		return $this->render('survey/create.html.twig', array(
			'form' => $form->createView()

		));




	}


}