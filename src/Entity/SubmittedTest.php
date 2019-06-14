<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubmittedTestRepository")
 */
class SubmittedTest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Test", inversedBy="submittedTests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $test_id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubmittedAnswer", mappedBy="submitted_test_id", orphanRemoval=true)
     */
    private $submittedAnswers;

    public function __construct()
    {
        $this->submittedAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestId(): ?Test
    {
        return $this->test_id;
    }

    public function setTestId(?Test $test_id): self
    {
        $this->test_id = $test_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

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
            $submittedAnswer->setSubmittedTestId($this);
        }

        return $this;
    }

    public function removeSubmittedAnswer(SubmittedAnswer $submittedAnswer): self
    {
        if ($this->submittedAnswers->contains($submittedAnswer)) {
            $this->submittedAnswers->removeElement($submittedAnswer);
            // set the owning side to null (unless already changed)
            if ($submittedAnswer->getSubmittedTestId() === $this) {
                $submittedAnswer->setSubmittedTestId(null);
            }
        }

        return $this;
    }

    /*public function __toString(): string  
    {
        return strval($this->getId());
    }*/
}
