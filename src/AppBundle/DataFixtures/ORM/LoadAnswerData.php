<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Answer;

class LoadAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
	    $answers = [
		    ['bleu', 'rouge', 'vert', 'jaune'],
			['hiver', 'printemps', 'été', 'autone'],
			['ville', 'camapagne', 'montagne', 'mer']
		];
        
		for($i = 0; $i < 3; ++$i) {
		    $question = $this->getReference('question-' . $i);
			
			foreach($answers[$i] as $wording) {
				$answer = new Answer();
				$answer->setAWording($wording);
				$answer->setQuestion($question);

				$manager->persist($answer);
			}
		}
        $manager->flush();
    }
	
	/** getOrder **/
	public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}