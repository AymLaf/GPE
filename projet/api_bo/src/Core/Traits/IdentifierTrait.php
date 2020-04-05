<?php

namespace App\Core\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait IdentifierTrait
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
    private $uuid;

    public function getId (): ?int {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUuid(): UuidInterface
    {
        return is_string($this->uuid) ? Uuid::fromString($this->uuid) : $this->uuid;
    }

    private function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }
}