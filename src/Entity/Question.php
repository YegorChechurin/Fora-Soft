<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\wordingRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wording;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Test", mappedBy="questions")
     */
    private $tests;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Answer", mappedBy="questions")
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubmittedAnswer", mappedBy="question_id", orphanRemoval=true)
     */
    private $submittedAnswers;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->submittedAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWording(): ?string
    {
        return $this->wording;
    }

    public function setWording(string $wording): self
    {
        $this->wording = $wording;

        return $this;
    }

    /**
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->addQuestion($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
            $test->removeQuestion($this);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->addQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            $answer->removeQuestion($this);
        }

        return $this;
    }

    /*public function __toString(): string 
    {
        return $this->getWording();
    }*/

    /**
     * @return Collection|SubmittedAnswer[]
     */
    public function getSubmittedAnswers(): Collection
    {
        return $this->submittedAnswers;
    }

    public function addSubmittedAnswer(SubmittedAnswer $submittedAnswer): self
    {
        if (!$this->submittedAnswers->contains($submittedAnswer)) {
            $this->submittedAnswers[] = $submittedAnswer;
            $submittedAnswer->setQuestionId($this);
        }

        return $this;
    }

    public function removeSubmittedAnswer(SubmittedAnswer $submittedAnswer): self
    {
        if ($this->submittedAnswers->contains($submittedAnswer)) {
            $this->submittedAnswers->removeElement($submittedAnswer);
            // set the owning side to null (unless already changed)
            if ($submittedAnswer->getQuestionId() === $this) {
                $submittedAnswer->setQuestionId(null);
            }
        }

        return $this;
    }
}
