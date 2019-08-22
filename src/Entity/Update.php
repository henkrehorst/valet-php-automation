<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Every update for the brew tap is stored here
 *
 * @ORM\Entity(repositoryClass="App\Repository\UpdateRepository")
 */
class Update
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $releaseVersion;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $packageHash;

    /**
     * @ORM\Column(type="integer")
     */
    private $rebuildVersion;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PhpVersion", inversedBy="updates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $phpVersion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlatformUpdate", mappedBy="mainUpdate")
     */
    private $platformUpdates;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $branch;

    public function __construct()
    {
        $this->platformUpdates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReleaseVersion(): ?string
    {
        return $this->releaseVersion;
    }

    public function setReleaseVersion(string $releaseVersion): self
    {
        $this->releaseVersion = $releaseVersion;

        return $this;
    }

    public function getPackageHash(): ?string
    {
        return $this->packageHash;
    }

    public function setPackageHash(string $packageHash): self
    {
        $this->packageHash = $packageHash;

        return $this;
    }

    public function getRebuildVersion(): ?int
    {
        return $this->rebuildVersion;
    }

    public function setRebuildVersion(int $rebuildVersion): self
    {
        $this->rebuildVersion = $rebuildVersion;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPhpVersion(): ?PhpVersion
    {
        return $this->phpVersion;
    }

    public function setPhpVersion(?PhpVersion $phpVersion): self
    {
        $this->phpVersion = $phpVersion;

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
            $platformUpdate->setParentUpdate($this);
        }

        return $this;
    }

    public function removePlatformUpdate(PlatformUpdate $platformUpdate): self
    {
        if ($this->platformUpdates->contains($platformUpdate)) {
            $this->platformUpdates->removeElement($platformUpdate);
            // set the owning side to null (unless already changed)
            if ($platformUpdate->getParentUpdate() === $this) {
                $platformUpdate->setParentUpdate(null);
            }
        }

        return $this;
    }

    public function getBranch(): ?string
    {
        return $this->branch;
    }

    public function setBranch(string $branch): self
    {
        $this->branch = $branch;

        return $this;
    }
}
