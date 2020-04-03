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
	 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
	 */
	class Owner {
        use IdentifierTrait;

		/**
		 * @ORM\Column(type="string", length=50)
		 */
		private $firstname;

		/**
		 * @ORM\Column(type="string", length=50)
		 */
		private $lastname;

		/**
		 * @ORM\Column(type="decimal", precision=4, scale=1)
		 */
		private $tantieme;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="owner", cascade={"persist", "remove"})
		 */
		private $user;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Lot", mappedBy="owner")
		 */
		private $lots;

		/**
		 * @ORM\ManyToMany(targetEntity="App\Entity\Meeting", mappedBy="owner")
		 */
		private $meetings;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="owner")
		 */
		private $votes;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="donor_owner")
		 */
		private $delegations_donor;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="receiver_owner")
		 */
		private $delegations_receiver;

        /**
         * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="owners")
         */
        private $building;

		public function __construct () {
			$this->lots = new ArrayCollection();
			$this->meetings = new ArrayCollection();
			$this->votes = new ArrayCollection();
			$this->delegations_donor = new ArrayCollection();
			$this->delegations_receiver = new ArrayCollection();
            $this->setUuid(Uuid::uuid4());
		}

		public function getFirstname (): ?string {
			return $this->firstname;
		}

		public function setFirstname (string $firstname): self {
			$this->firstname = $firstname;

			return $this;
		}

		public function getLastname (): ?string {
			return $this->lastname;
		}

		public function setLastname (string $lastname): self {
			$this->lastname = $lastname;

			return $this;
		}

		public function getTantieme (): ?string {
			return $this->tantieme;
		}

		public function setTantieme (string $tantieme): self {
			$this->tantieme = $tantieme;

			return $this;
		}

		public function getUser (): ?User {
			return $this->user;
		}

		public function setUser (?User $user): self {
			$this->user = $user;

			// set (or unset) the owning side of the relation if necessary
			$newOwner = null === $user ? null : $this;
			if ($user->getOwner() !== $newOwner) {
				$user->setOwner($newOwner);
			}

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
				$lot->setOwner($this);
			}

			return $this;
		}

		public function removeLot (Lot $lot): self {
			if ($this->lots->contains($lot)) {
				$this->lots->removeElement($lot);
				// set the owning side to null (unless already changed)
				if ($lot->getOwner() === $this) {
					$lot->setOwner(null);
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
				$meeting->addOwner($this);
			}

			return $this;
		}

		public function removeMeeting (Meeting $meeting): self {
			if ($this->meetings->contains($meeting)) {
				$this->meetings->removeElement($meeting);
				$meeting->removeOwner($this);
			}

			return $this;
		}

		/**
		 * @return Collection|Vote[]
		 */
		public function getVotes (): Collection {
			return $this->votes;
		}

		public function addVote (Vote $vote): self {
			if (!$this->votes->contains($vote)) {
				$this->votes[] = $vote;
				$vote->setOwner($this);
			}

			return $this;
		}

		public function removeVote (Vote $vote): self {
			if ($this->votes->contains($vote)) {
				$this->votes->removeElement($vote);
				// set the owning side to null (unless already changed)
				if ($vote->getOwner() === $this) {
					$vote->setOwner(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection|Delegation[]
		 */
		public function getDelegationsDonor (): Collection {
			return $this->delegations_donor;
		}

		/**
		 * @return Collection|Delegation[]
		 */
		public function getDelegationsReceiver (): Collection {
			return $this->delegations_receiver;
		}

        public function getBuilding (): ?Building {
            return $this->building;
        }

        public function setBuilding (?Building $building): self {
            $this->building = $building;

            return $this;
        }
	}
