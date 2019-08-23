<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Every php version in the brew tap is here stored
 *
 * @ORM\Entity(repositoryClass="App\Repository\PhpVersionRepository")
 */
class PhpVersion
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $minorVersion;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $currentReleaseVersion;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Update", mappedBy="phpVersion", orphanRemoval=true)
     */
    private $updates;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getMinorVersion(): ?string
    {
        return $this->minorVersion;
    }

    public function setMinorVersion(string $minorVersion): self
    {
        $this->minorVersion = $minorVersion;

        return $this;
    }

    public function getCurrentReleaseVersion(): ?string
    {
        return $this->currentReleaseVersion;
    }

    public function setCurrentReleaseVersion(string $currentReleaseVersion): self
    {
        $this->currentReleaseVersion = $currentReleaseVersion;

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
     * @return Collection|Update[]
     */
    public function getUpdates(): Collection
    {
        return $this->updates;
    }

    public function addUpdate(Update $update): self
    {
        if (!$this->updates->contains($update)) {
            $this->updates[] = $update;
            $update->setPhpVersion($this);
        }

        return $this;
    }

    public function removeUpdate(Update $update): self
    {
        if ($this->updates->contains($update)) {
            $this->updates->removeElement($update);
            // set the owning side to null (unless already changed)
            if ($update->getPhpVersion() === $this) {
                $update->setPhpVersion(null);
            }
        }

        return $this;
    }
}
