<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     * @Assert\Type(type="array")
     * @Assert\Valid()
     */
    protected $answers = [];

    /**
     * @ORM\ManyToOne(targetEntity="Survey", inversedBy="questions")
	 * @ORM\JoinColumn(name="survey_id", referencedColumnName="id")
     * @Assert\Type(type="AppBundle\Entity\Survey")
     * @Assert\Valid()
     */
    protected $survey;

    /**
     * @var string
     *
     * @ORM\Column(name="wording", type="text", nullable=true)
     */
    private $wording;
	
	 /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set survey
     *
     * @param \AppBundle\Entity\Survey $survey
     *
     * @return Question
     */
    public function setSurvey(\AppBundle\Entity\Survey $survey = null)
    {
        $this->survey = $survey;

        return $this;
    }

    /**
     * Get survey
     *
     * @return \AppBundle\Entity\Survey
     */
    public function getSurvey()
    {
        return $this->survey;
    }


    /**
     * Set wording
     *
     * @param string $wording
     *
     * @return Question
     */
    public function setWording($wording)
    {
        $this->wording = $wording;

        return $this;
    }

    /**
     * Get wording
     *
     * @return string
     */
    public function getWording()
    {
        return $this->wording;
    }

    /**
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return Question
     */
    public function addAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\Answer $answer
     */
    public function removeAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
