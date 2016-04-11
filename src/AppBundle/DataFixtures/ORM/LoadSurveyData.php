<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Survey;

class LoadSurveyData extends AbstractFixture implements OrderedFixtureInterface
{
	/** load **/
    public function load(ObjectManager $manager)
    {
        $survey = new Survey();
		$survey->setWording('Ceci est le sondage Popinion n°1');
        $survey->setTitle('Sondage Popinion n°1');
		$survey->setSlug('sontage-popinion-1');

        $manager->persist($survey);
        $manager->flush();
		
		$this->addReference('sontage-popinion-1', $survey);
    }
	
	/** getOrder **/
	public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}