<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @var string
     *
     * @ORM\Column(name="Awording", type="string", nullable=true)
     */
    private $Awording;
    /**
     * @var int
     *
     * @ORM\Column(name="vote", type="integer")
     */
    private $vote = 0;
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * @Assert\Type(type="AppBundle\Entity\Question")
     * @Assert\Valid()
     */
    protected $question;
    
    /**
     * @var boolean
     */
    private $checked = false;
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
     * Set vote
     *
     * @param integer $vote
     *
     * @return Answer
     */
    public function setVote($vote = 0)
    {
        $this->vote = $vote;
        return $this;
    }
    /**
     * Get vote
     *
     * @return int
     */
    public function getVote()
    {
        return $this->vote;
    }
    /**
     * increment vote count
     *
     * @param integer $value
     *
     * @return Answer
     */
    public function incrementVote($value = 1)
    {
        $this->vote += $value;
        return $this;
    }
    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;
        return $this;
    }
    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
    /**
     * Set Awording
     *
     * @param string $Awording
     *
     * @return Answer
     */
    public function setAwording($Awording)
    {
        $this->Awording = $Awording;
        return $this;
    }
    /**
     * Get Awording
     *
     * @return string
     */
    public function getAwording()
    {
        return $this->Awording;
    }
    
    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return Answer
     */
    public function setChecked($checked = false)
    {
        $this->checked = $checked;
        return $this;
    }
    /**
     * Get checked
     *
     * @return boolean
     */
    public function getChecked()
    {
        return $this->checked;
    }
}