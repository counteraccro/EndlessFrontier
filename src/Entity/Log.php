<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log
{

    /**
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     *
     * @ORM\Column(type="text")
     */
    private $log;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Raid", inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Raid;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

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

    public function getLog(): ?string
    {
        return $this->log;
    }

    public function setLog(string $log): self
    {
        $this->log = $log;

        return $this;
    }

    public function getRaid(): ?Raid
    {
        return $this->Raid;
    }

    public function setRaid(?Raid $Raid): self
    {
        $this->Raid = $Raid;

        return $this;
    }
}
