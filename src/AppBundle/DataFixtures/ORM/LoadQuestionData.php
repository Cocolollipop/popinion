<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Question;

class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
	    $questions = [
		    'Quelle est votre couleur préférée?',
			'Quelle est votre saison préférée?',
			'Quelle environnement préférez vous?',
		];
	    $survey = $this->getReference('sontage-popinion-1');
        
		foreach($questions as $k => $wording) {
			$question = new Question();
			$question->setWording($wording);
			$question->setSurvey($survey);

			$manager->persist($question);
			$this->addReference('question-' . $k, $question);
		}
        $manager->flush();
    }
	
	/** getOrder **/
	public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}