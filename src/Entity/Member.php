<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 * @UniqueEntity("name",  message="Ce membre est déjà dans la guilde.")
 */
class Member
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
     * @ORM\Column(type="integer")
     */
    private $Kl;

    /**
     * @ORM\Column(type="integer")
     */
    private $bonus_malus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoxMember", mappedBy="Member", orphanRemoval=true)
     */
    private $boxMembers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disabled;

    public function __construct()
    {
        $this->Box = new ArrayCollection();
        $this->boxMembers = new ArrayCollection();
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

    public function getKl(): ?int
    {
        return $this->Kl;
    }

    public function setKl(int $Kl): self
    {
        $this->Kl = $Kl;

        return $this;
    }

    public function getBonusMalus(): ?int
    {
        return $this->bonus_malus;
    }

    public function setBonusMalus(int $bonus_malus): self
    {
        $this->bonus_malus = $bonus_malus;

        return $this;
    }

    /**
     * @return Collection|BoxMember[]
     */
    public function getBoxMembers(): Collection
    {
        return $this->boxMembers;
    }

    public function addBoxMember(BoxMember $boxMember): self
    {
        if (!$this->boxMembers->contains($boxMember)) {
            $this->boxMembers[] = $boxMember;
            $boxMember->setMember($this);
        }

        return $this;
    }

    public function removeBoxMember(BoxMember $boxMember): self
    {
        if ($this->boxMembers->contains($boxMember)) {
            $this->boxMembers->removeElement($boxMember);
            // set the owning side to null (unless already changed)
            if ($boxMember->getMember() === $this) {
                $boxMember->setMember(null);
            }
        }

        return $this;
    }

    public function getDisabled(): ?bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;

        return $this;
    }
}
