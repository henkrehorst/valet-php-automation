<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Every platform and associated information is stored here
 *
 * @ORM\Entity(repositoryClass="App\Repository\PlatformRepository")
 */
class Platform
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $ciCd;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $imageName;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlatformUpdate", mappedBy="Platform")
     */
    private $platformUpdates;

    public function __construct()
    {
        $this->platformUpdates = new ArrayCollection();
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

    public function getCiCd(): ?string
    {
        return $this->ciCd;
    }

    public function setCiCd(string $ciCd): self
    {
        $this->ciCd = $ciCd;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|PlatformUpdate[]
     */
    public function getPlatformUpdates(): Collection
    {
        return $this->platformUpdates;
    }

    public function addPlatformUpdate(PlatformUpdate $platformUpdate): self
    {
        if (!$this->platformUpdates->contains($platformUpdate)) {
            $this->platformUpdates[] = $platformUpdate;
            $platformUpdate->setPlatform($this);
        }

        return $this;
    }

    public function removePlatformUpdate(PlatformUpdate $platformUpdate): self
    {
        if ($this->platformUpdates->contains($platformUpdate)) {
            $this->platformUpdates->removeElement($platformUpdate);
            // set the owning side to null (unless already changed)
            if ($platformUpdate->getPlatform() === $this) {
                $platformUpdate->setPlatform(null);
            }
        }

        return $this;
    }
}
