<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxMemberRepository")
 */
class BoxMember
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="boxMembers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Box", inversedBy="boxMembers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Box;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->Member;
    }

    public function setMember(?Member $Member): self
    {
        $this->Member = $Member;

        return $this;
    }

    public function getBox(): ?Box
    {
        return $this->Box;
    }

    public function setBox(?Box $Box): self
    {
        $this->Box = $Box;

        return $this;
    }
}
