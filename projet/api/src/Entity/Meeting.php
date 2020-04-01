<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
    use App\Core\Traits\IdentifierTrait;
    use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\Mapping as ORM;
    use Ramsey\Uuid\Uuid;

    /**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\MeetingRepository")
	 */
	class Meeting {
        use IdentifierTrait;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="meetings")
		 */
		private $building;

		/**
		 * @ORM\Column(type="datetime")
		 */
		private $date;

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $file_name;

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $guest_link;

		/**
		 * @ORM\Column(type="smallint")
		 */
		private $live;

		/**
		 * @ORM\ManyToMany(targetEntity="App\Entity\Owner", inversedBy="meetings")
		 */
		private $owner;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Resolution", mappedBy="meeting")
		 */
		private $resolutions;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="meeting")
		 */
		private $delegations;

		public function __construct () {
			$this->owner = new ArrayCollection();
			$this->resolutions = new ArrayCollection();
			$this->delegations = new ArrayCollection();
            $this->setUuid(Uuid::uuid4());
		}

		public function getBuilding (): ?Building {
			return $this->building;
		}

		public function setBuilding (?Building $building): self {
			$this->building = $building;

			return $this;
		}

		public function getDate (): ?\DateTimeInterface {
			return $this->date;
		}

		public function setDate (\DateTimeInterface $date): self {
			$this->date = $date;

			return $this;
		}

		public function getFileName (): ?string {
			return $this->file_name;
		}

		public function setFileName (string $file_name): self {
			$this->file_name = $file_name;

			return $this;
		}

		public function getGuestLink (): ?string {
			return $this->guest_link;
		}

		public function setGuestLink (string $guest_link): self {
			$this->guest_link = $guest_link;

			return $this;
		}

		public function getLive (): ?int {
			return $this->live;
		}

		public function setLive (int $live): self {
			$this->live = $live;

			return $this;
		}

		/**
		 * @return Collection|Owner[]
		 */
		public function getOwner (): Collection {
			return $this->owner;
		}

		public function addOwner (Owner $owner): self {
			if (!$this->owner->contains($owner)) {
				$this->owner[] = $owner;
			}

			return $this;
		}

		public function removeOwner (Owner $owner): self {
			if ($this->owner->contains($owner)) {
				$this->owner->removeElement($owner);
			}

			return $this;
		}

		/**
		 * @return Collection|Resolution[]
		 */
		public function getResolutions (): Collection {
			return $this->resolutions;
		}

		public function addResolution (Resolution $resolution): self {
			if (!$this->resolutions->contains($resolution)) {
				$this->resolutions[] = $resolution;
				$resolution->setMeeting($this);
			}

			return $this;
		}

		public function removeResolution (Resolution $resolution): self {
			if ($this->resolutions->contains($resolution)) {
				$this->resolutions->removeElement($resolution);
				// set the owning side to null (unless already changed)
				if ($resolution->getMeeting() === $this) {
					$resolution->setMeeting(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection|Delegation[]
		 */
		public function getDelegations (): Collection {
			return $this->delegations;
		}

		public function addDelegation (Delegation $delegation): self {
			if (!$this->delegations->contains($delegation)) {
				$this->delegations[] = $delegation;
				$delegation->setMeeting($this);
			}

			return $this;
		}

		public function removeDelegation (Delegation $delegation): self {
			if ($this->delegations->contains($delegation)) {
				$this->delegations->removeElement($delegation);
				// set the owning side to null (unless already changed)
				if ($delegation->getMeeting() === $this) {
					$delegation->setMeeting(null);
				}
			}

			return $this;
		}
	}
