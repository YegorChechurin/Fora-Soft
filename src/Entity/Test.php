<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 */
class Test
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", inversedBy="tests")
     */
    private $questions;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubmittedTest", mappedBy="test_id", orphanRemoval=true)
     */
    private $submittedTests;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->submittedTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|SubmittedTest[]
     */
    public function getSubmittedTests(): Collection
    {
        return $this->submittedTests;
    }

    public function addSubmittedTest(SubmittedTest $submittedTest): self
    {
        if (!$this->submittedTests->contains($submittedTest)) {
            $this->submittedTests[] = $submittedTest;
            $submittedTest->setTestId($this);
        }

        return $this;
    }

    public function removeSubmittedTest(SubmittedTest $submittedTest): self
    {
        if ($this->submittedTests->contains($submittedTest)) {
            $this->submittedTests->removeElement($submittedTest);
            // set the owning side to null (unless already changed)
            if ($submittedTest->getTestId() === $this) {
                $submittedTest->setTestId(null);
            }
        }

        return $this;
    }

    /*public function __toString(): string  
    {
        return strval($this->getId());
    }*/
}
