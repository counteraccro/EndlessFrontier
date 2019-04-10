<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaidRepository")
 */
class Raid
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
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Box", mappedBy="raid", orphanRemoval=true)
     */
    private $box;

    public function __construct()
    {
        $this->box = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection|Box[]
     */
    public function getBox(): Collection
    {
        return $this->box;
    }

    public function addBox(Box $box): self
    {
        if (!$this->box->contains($box)) {
            $this->box[] = $box;
            $box->setRaid($this);
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->box->contains($box)) {
            $this->box->removeElement($box);
            // set the owning side to null (unless already changed)
            if ($box->getRaid() === $this) {
                $box->setRaid(null);
            }
        }

        return $this;
    }
}
