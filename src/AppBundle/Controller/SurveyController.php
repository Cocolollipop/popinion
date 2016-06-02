<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
class SurveyController extends Controller {


    /**
     * @Route("/sondages", name="survey-list")
     */
    public function listSurveyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $surveys = $em->getRepository('AppBundle:Survey')->findAll();
        return $this->render('survey/list.html.twig', ['surveys' => $surveys]);
    }

    /**
     * @Route("/sondage/delete/{slug}", name="delete-survey")
     */
    public function deleteSurveyAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('AppBundle:Survey')->findOneBySlug($slug);
        $em->remove($survey);
        $em->flush();
        return $this->redirect($this->generateUrl('survey-list'));
    }

    /**
     * @Route("/sondage/edit/{slug}", name="edit-survey")
     */
    public function editSurveyAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
         $survey = $em->getRepository('AppBundle:Survey')->findOneBySlug($slug);
          $title=$survey->getTitle();
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);
        $nbQuestion = 0;

         $questions = $survey->getQuestions();
            foreach ($questions as $question) {
               $nbQuestion++;
           }

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($questions as $question) {
                $answers = $question->getAnswers();
                foreach ($answers as $answer) {
                        $answer->setVote();
                    }
                }
            $em->persist($survey);

            $em->flush();
            $slug = str_replace(" ", '-', $survey->getTitle());
            $slug = $slug.'-'.$survey->getId();
            $survey->setSlug($slug);
            $em->flush(); 
            return $this->redirect($this->generateUrl('survey-list'));
        }
        
        //NB: Add a constraint
        return $this->render('survey/edit.html.twig',['form' => $form->createView(), 'nbQuestion' => $nbQuestion, 'title'=>$title]
            );
    }



    /**
     * @Route("/sondage/{slug}", name="new-survey")
     */
    public function newSurveyAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        //Create an object survey
        $survey = $em->getRepository('AppBundle:Survey')->findOneBySlug($slug);
        $title=$survey->getTitle();
        
        if ($survey == null) {
            //add an error page
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(SurveyType::class, $survey, ['method' => 'PATCH']);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //add a vote
            $counter = $survey->getCounter();
            $survey->setCounter(++$counter);
            $questions = $survey->getQuestions();
            foreach ($questions as $question) {
                $answers = $question->getAnswers();
                foreach ($answers as $answer) {
                    if($answer->getChecked()) {
                        $answer->incrementVote();
                    }
                }
            }
            $em->flush();
            //Redirection
            //NB: Add a message


            return $this->redirect($this->generateUrl('survey-list'));
        }
        //NB: Add a constraint
        return $this->render('survey/form.html.twig', array(
                    'form' => $form->createView(), 'title'=>$title
        ));
    }
    /**
     * @Route("/creer-sondage", name="add-survey")
     */
    public function addSurveyAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $survey = new Survey();
        $question = new Question();
        $question->addAnswer(new Answer());
        $survey->addQuestion($question);
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($survey);
            $em->flush();
            $slug = str_replace(" ", '-', $survey->getTitle());
            $slug = $slug.'-'.$survey->getId();
            $survey->setSlug($slug);
            $em->flush(); 
            return $this->redirect($this->generateUrl('survey-list'));
        }
        
        //NB: Add a constraint
        return $this->render('survey/create.html.twig', ['form' => $form->createView()]);
    }

  
}

  