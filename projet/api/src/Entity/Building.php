<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\BuildingRepository")
	 */
	class Building {
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

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $address;

		/**
		 * @ORM\Column(type="integer")
		 */
		private $number;

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $city;

		/**
		 * @ORM\Column(type="string", length=255, nullable=true)
		 */
		private $complement;

		/**
		 * @ORM\Column(type="string", length=10)
		 */
		private $zip_code;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Syndic", inversedBy="buildings")
		 */
		private $syndic;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Lot", mappedBy="building")
		 */
		private $lots;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Meeting", mappedBy="building")
		 */
		private $meetings;

		public function __construct () {
			$this->lots = new ArrayCollection();
			$this->meetings = new ArrayCollection();
		}

		public function getId (): ?int {
			return $this->id;
		}

		public function getUuid (): ?string {
			return $this->uuid;
		}

		public function setUuid (string $uuid): self {
			$this->uuid = $uuid;

			return $this;
		}

		public function getAddress (): ?string {
			return $this->address;
		}

		public function setAddress (string $address): self {
			$this->address = $address;

			return $this;
		}

		public function getNumber (): ?int {
			return $this->number;
		}

		public function setNumber (int $number): self {
			$this->number = $number;

			return $this;
		}

		public function getCity (): ?string {
			return $this->city;
		}

		public function setCity (string $city): self {
			$this->city = $city;

			return $this;
		}

		public function getComplement (): ?string {
			return $this->complement;
		}

		public function setComplement (?string $complement): self {
			$this->complement = $complement;

			return $this;
		}

		public function getZipCode (): ?string {
			return $this->zip_code;
		}

		public function setZipCode (string $zip_code): self {
			$this->zip_code = $zip_code;

			return $this;
		}

		public function getSyndic (): ?Syndic {
			return $this->syndic;
		}

		public function setSyndic (?Syndic $syndic): self {
			$this->syndic = $syndic;

			return $this;
		}

		/**
		 * @return Collection|Lot[]
		 */
		public function getLots (): Collection {
			return $this->lots;
		}

		public function addLot (Lot $lot): self {
			if (!$this->lots->contains($lot)) {
				$this->lots[] = $lot;
				$lot->setBuilding($this);
			}

			return $this;
		}

		public function removeLot (Lot $lot): self {
			if ($this->lots->contains($lot)) {
				$this->lots->removeElement($lot);
				// set the owning side to null (unless already changed)
				if ($lot->getBuilding() === $this) {
					$lot->setBuilding(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection|Meeting[]
		 */
		public function getMeetings (): Collection {
			return $this->meetings;
		}

		public function addMeeting (Meeting $meeting): self {
			if (!$this->meetings->contains($meeting)) {
				$this->meetings[] = $meeting;
				$meeting->setBuilding($this);
			}

			return $this;
		}

		public function removeMeeting (Meeting $meeting): self {
			if ($this->meetings->contains($meeting)) {
				$this->meetings->removeElement($meeting);
				// set the owning side to null (unless already changed)
				if ($meeting->getBuilding() === $this) {
					$meeting->setBuilding(null);
				}
			}

			return $this;
		}
	}