<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 */
class Test
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
    private $oui;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOui(): ?string
    {
        return $this->oui;
    }

    public function setOui(string $oui): self
    {
        $this->oui = $oui;

        return $this;
    }
}
