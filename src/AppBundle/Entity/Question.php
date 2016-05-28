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
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist"})
     * @Assert\Valid()
     */
    protected $answers = [];

    /**
     * @ORM\ManyToOne(targetEntity="Survey", inversedBy="questions", cascade={"persist"})
	 * @ORM\JoinColumn(name="survey_id", referencedColumnName="id")
     * @Assert\Type(type="AppBundle\Entity\Survey")
     * @Assert\Valid()
     */
    protected $survey;

    /**
     * @var string
     *
     * @ORM\Column(name="Qwording", type="string", nullable=true)
     */
    private $Qwording;
	
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
     * Set Qwording
     *
     * @param string $Qwording
     *
     * @return Question
     */
    public function setQwording($Qwording)
    {
        $this->Qwording = $Qwording;

        return $this;
    }

    /**
     * Get Qwording
     *
     * @return string
     */
    public function getQwording()
    {
        return $this->Qwording;
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
	    $answer->setQuestion($this);
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
	    $answer->setQuestion(null);
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
