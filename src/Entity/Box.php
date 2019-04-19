<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\BoxRepository")
 */
class Box
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
     * @ORM\Column(type="integer")
     */
    private $blockId;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $bossKindNum;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $star;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $plusTribe;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $plusValue;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $minusTribe;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $minusValue;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $meleeDef;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $rangeDef;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $gem;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $honorCoin;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $petKindNum;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $numPet;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $petKindNum2;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $numPet2;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $guildCoin;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $raidCoin;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $incAttack;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $decSpeed;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $resistType;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $resAttRatioMin;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $resAttRatioMax;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $resDefRatioMin;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $resDefRatioMax;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $attResMin;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $attResMax;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $defResMin;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $defResMax;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $recommendResist;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $showRecommendResist;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Raid", inversedBy="box")
     * @ORM\JoinColumn(nullable=false)
     */
    private $raid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoxMember", mappedBy="Box", orphanRemoval=true)
     */
    private $boxMembers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoxInfo", mappedBy="box", orphanRemoval=true)
     */
    private $BoxInfo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoxConstraint", mappedBy="box", orphanRemoval=true)
     */
    private $boxConstraints;

    public function __construct()
    {
        $this->boxMembers = new ArrayCollection();
        $this->BoxInfo = new ArrayCollection();
        $this->boxConstraints = new ArrayCollection();
    }

    public function getRaid(): ?Raid
    {
        return $this->raid;
    }

    public function setRaid(?Raid $raid): self
    {
        $this->raid = $raid;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlockId(): ?int
    {
        return $this->blockId;
    }

    public function setBlockId(int $blockId): self
    {
        $this->blockId = $blockId;

        return $this;
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

    public function getBossKindNum(): ?int
    {
        return $this->bossKindNum;
    }

    public function setBossKindNum(int $bossKindNum): self
    {
        $this->bossKindNum = $bossKindNum;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getStar(): ?int
    {
        return $this->star;
    }

    public function setStar(int $star): self
    {
        $this->star = $star;

        return $this;
    }

    public function getPlusTribe(): ?string
    {
        return $this->plusTribe;
    }

    public function setPlusTribe(string $plusTribe): self
    {
        $this->plusTribe = $plusTribe;

        return $this;
    }

    public function getPlusValue(): ?int
    {
        return $this->plusValue;
    }

    public function setPlusValue(int $plusValue): self
    {
        $this->plusValue = $plusValue;

        return $this;
    }

    public function getMinusTribe(): ?string
    {
        return $this->minusTribe;
    }

    public function setMinusTribe(string $minusTribe): self
    {
        $this->minusTribe = $minusTribe;

        return $this;
    }

    public function getMinusValue(): ?int
    {
        return $this->minusValue;
    }

    public function setMinusValue(int $minusValue): self
    {
        $this->minusValue = $minusValue;

        return $this;
    }

    public function getMeleeDef(): ?int
    {
        return $this->meleeDef;
    }

    public function setMeleeDef(int $meleeDef): self
    {
        $this->meleeDef = $meleeDef;

        return $this;
    }

    public function getRangeDef(): ?int
    {
        return $this->rangeDef;
    }

    public function setRangeDef(int $rangeDef): self
    {
        $this->rangeDef = $rangeDef;

        return $this;
    }

    public function getGem(): ?int
    {
        return $this->gem;
    }

    public function setGem(int $gem): self
    {
        $this->gem = $gem;

        return $this;
    }

    public function getHonorCoin(): ?int
    {
        return $this->honorCoin;
    }

    public function setHonorCoin(int $honorCoin): self
    {
        $this->honorCoin = $honorCoin;

        return $this;
    }

    public function getPetKindNum(): ?int
    {
        return $this->petKindNum;
    }

    public function setPetKindNum(int $petKindNum): self
    {
        $this->petKindNum = $petKindNum;

        return $this;
    }

    public function getNumPet(): ?int
    {
        return $this->numPet;
    }

    public function setNumPet(int $numPet): self
    {
        $this->numPet = $numPet;

        return $this;
    }

    public function getPetKindNum2(): ?int
    {
        return $this->petKindNum2;
    }

    public function setPetKindNum2(int $petKindNum2): self
    {
        $this->petKindNum2 = $petKindNum2;

        return $this;
    }

    public function getNumPet2(): ?int
    {
        return $this->numPet2;
    }

    public function setNumPet2(int $numPet2): self
    {
        $this->numPet2 = $numPet2;

        return $this;
    }

    public function getGuildCoin(): ?int
    {
        return $this->guildCoin;
    }

    public function setGuildCoin(int $guildCoin): self
    {
        $this->guildCoin = $guildCoin;

        return $this;
    }

    public function getRaidCoin(): ?int
    {
        return $this->raidCoin;
    }

    public function setRaidCoin(int $raidCoin): self
    {
        $this->raidCoin = $raidCoin;

        return $this;
    }

    public function getIncAttack(): ?float
    {
        return $this->incAttack;
    }

    public function setIncAttack(float $incAttack): self
    {
        $this->incAttack = $incAttack;

        return $this;
    }

    public function getDecSpeed(): ?float
    {
        return $this->decSpeed;
    }

    public function setDecSpeed(float $decSpeed): self
    {
        $this->decSpeed = $decSpeed;

        return $this;
    }

    public function getResistType(): ?int
    {
        return $this->resistType;
    }

    public function setResistType(int $resistType): self
    {
        $this->resistType = $resistType;

        return $this;
    }

    public function getResAttRatioMin(): ?float
    {
        return $this->resAttRatioMin;
    }

    public function setResAttRatioMin(float $resAttRatioMin): self
    {
        $this->resAttRatioMin = $resAttRatioMin;

        return $this;
    }

    public function getResAttRatioMax(): ?float
    {
        return $this->resAttRatioMax;
    }

    public function setResAttRatioMax(float $resAttRatioMax): self
    {
        $this->resAttRatioMax = $resAttRatioMax;

        return $this;
    }

    public function getResDefRatioMin(): ?float
    {
        return $this->resDefRatioMin;
    }

    public function setResDefRatioMin(float $resDefRatioMin): self
    {
        $this->resDefRatioMin = $resDefRatioMin;

        return $this;
    }

    public function getResDefRatioMax(): ?float
    {
        return $this->resDefRatioMax;
    }

    public function setResDefRatioMax(float $resDefRatioMax): self
    {
        $this->resDefRatioMax = $resDefRatioMax;

        return $this;
    }

    public function getAttResMin(): ?float
    {
        return $this->attResMin;
    }

    public function setAttResMin(float $attResMin): self
    {
        $this->attResMin = $attResMin;

        return $this;
    }

    public function getAttResMax(): ?float
    {
        return $this->attResMax;
    }

    public function setAttResMax(float $attResMax): self
    {
        $this->attResMax = $attResMax;

        return $this;
    }

    public function getDefResMin(): ?float
    {
        return $this->defResMin;
    }

    public function setDefResMin(float $defResMin): self
    {
        $this->defResMin = $defResMin;

        return $this;
    }

    public function getDefResMax(): ?float
    {
        return $this->defResMax;
    }

    public function setDefResMax(float $defResMax): self
    {
        $this->defResMax = $defResMax;

        return $this;
    }

    public function getRecommendResist(): ?int
    {
        return $this->recommendResist;
    }

    public function setRecommendResist(int $recommendResist): self
    {
        $this->recommendResist = $recommendResist;

        return $this;
    }

    public function getShowRecommendResist(): ?string
    {
        return $this->showRecommendResist;
    }

    public function setShowRecommendResist(string $showRecommendResist): self
    {
        $this->showRecommendResist = $showRecommendResist;

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
            $boxMember->setBox($this);
        }

        return $this;
    }

    public function removeBoxMember(BoxMember $boxMember): self
    {
        if ($this->boxMembers->contains($boxMember)) {
            $this->boxMembers->removeElement($boxMember);
            // set the owning side to null (unless already changed)
            if ($boxMember->getBox() === $this) {
                $boxMember->setBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BoxInfo[]
     */
    public function getBoxInfo(): Collection
    {
        return $this->BoxInfo;
    }

    public function addBoxInfo(BoxInfo $boxInfo): self
    {
        if (!$this->BoxInfo->contains($boxInfo)) {
            $this->BoxInfo[] = $boxInfo;
            $boxInfo->setBox($this);
        }

        return $this;
    }

    public function removeBoxInfo(BoxInfo $boxInfo): self
    {
        if ($this->BoxInfo->contains($boxInfo)) {
            $this->BoxInfo->removeElement($boxInfo);
            // set the owning side to null (unless already changed)
            if ($boxInfo->getBox() === $this) {
                $boxInfo->setBox(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BoxConstraint[]
     */
    public function getBoxConstraints(): Collection
    {
        return $this->boxConstraints;
    }

    public function addBoxConstraint(BoxConstraint $boxConstraint): self
    {
        if (!$this->boxConstraints->contains($boxConstraint)) {
            $this->boxConstraints[] = $boxConstraint;
            $boxConstraint->setBox($this);
        }

        return $this;
    }

    public function removeBoxConstraint(BoxConstraint $boxConstraint): self
    {
        if ($this->boxConstraints->contains($boxConstraint)) {
            $this->boxConstraints->removeElement($boxConstraint);
            // set the owning side to null (unless already changed)
            if ($boxConstraint->getBox() === $this) {
                $boxConstraint->setBox(null);
            }
        }

        return $this;
    }
}
