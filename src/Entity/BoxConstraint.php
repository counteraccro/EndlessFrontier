<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxConstraintRepository")
 */
class BoxConstraint
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbOpen;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Box", inversedBy="boxConstraints")
     */
    private $box;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbOpen(): ?int
    {
        return $this->nbOpen;
    }

    public function setNbOpen(int $nbOpen): self
    {
        $this->nbOpen = $nbOpen;

        return $this;
    }

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }
}
