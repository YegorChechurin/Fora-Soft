<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubmittedAnswerRepository")
 */
class SubmittedAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubmittedTest", inversedBy="submittedAnswers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $submitted_test_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="submittedAnswers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubmittedTestId(): ?SubmittedTest
    {
        return $this->submitted_test_id;
    }

    public function setSubmittedTestId(?SubmittedTest $submitted_test_id): self
    {
        $this->submitted_test_id = $submitted_test_id;

        return $this;
    }

    public function getQuestionId(): ?Question
    {
        return $this->question_id;
    }

    public function setQuestionId(?Question $question_id): self
    {
        $this->question_id = $question_id;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
