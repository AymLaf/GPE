<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
    use App\Core\Traits\IdentifierTrait;
    use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\SyndicRepository")
	 */
	class Syndic {
        use IdentifierTrait;

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $name;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="syndic", cascade={"persist", "remove"})
		 */
		private $user;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Building", mappedBy="syndic")
		 */
		private $buildings;

		public function __construct () {
			$this->buildings = new ArrayCollection();
		}

		public function getName (): ?string {
			return $this->name;
		}

		public function setName (string $name): self {
			$this->name = $name;

			return $this;
		}

		public function getUser (): ?User {
			return $this->user;
		}

		public function setUser (?User $user): self {
			$this->user = $user;

			// set (or unset) the owning side of the relation if necessary
			$newSyndic = null === $user ? null : $this;
			if ($user->getSyndic() !== $newSyndic) {
				$user->setSyndic($newSyndic);
			}

			return $this;
		}

		/**
		 * @return Collection|Building[]
		 */
		public function getBuildings (): Collection {
			return $this->buildings;
		}

		public function addBuilding (Building $building): self {
			if (!$this->buildings->contains($building)) {
				$this->buildings[] = $building;
				$building->setSyndic($this);
			}

			return $this;
		}

		public function removeBuilding (Building $building): self {
			if ($this->buildings->contains($building)) {
				$this->buildings->removeElement($building);
				// set the owning side to null (unless already changed)
				if ($building->getSyndic() === $this) {
					$building->setSyndic(null);
				}
			}

			return $this;
		}
	}
