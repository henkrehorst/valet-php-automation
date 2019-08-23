<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Entity(repositoryClass="App\Repository\PlatformUpdateRepository")
 */
class PlatformUpdate
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
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $bottleHash;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Update", inversedBy="platformUpdates")
     */
    private $parentUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Platform", inversedBy="platformUpdates")
     */
    private $Platform;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getBottleHash(): ?string
    {
        return $this->bottleHash;
    }

    public function setBottleHash(?string $bottleHash): self
    {
        $this->bottleHash = $bottleHash;

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
     * @return mixed
     */
    public function getParentUpdate()
    {
        return $this->parentUpdate;
    }

    /**
     * @param mixed $parentUpdate
     */
    public function setParentUpdate($parentUpdate): self
    {
        $this->parentUpdate = $parentUpdate;

        return $this;
    }
    public function getPlatform(): ?Platform
    {
        return $this->Platform;
    }

    public function setPlatform(?Platform $Platform): self
    {
        $this->Platform = $Platform;

        return $this;
    }
}
