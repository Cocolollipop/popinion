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
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="answer")
     * @Assert\Type(type="AppBundle\Entity\Answer")
     * @Assert\Valid()
     */
    protected $answers = [];

    /**
     * @ORM\ManyToOne(targetEntity="Survey", inversedBy="survey")
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set answers
     *
     * @param \AppBundle\Entity\Answer $answers
     *
     * @return Question
     */
    public function setAnswers(\AppBundle\Entity\Answer $answers = null)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get answers
     *
     * @return \AppBundle\Entity\Answer
     */
    public function getAnswers()
    {
        return $this->answers;
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
}
