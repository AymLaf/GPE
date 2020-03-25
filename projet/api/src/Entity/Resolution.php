<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\ResolutionRepository")
	 */
	class Resolution {
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
		 * @ORM\ManyToOne(targetEntity="App\Entity\Meeting", inversedBy="resolutions")
		 */
		private $meeting;

		/**
		 * @ORM\Column(type="string", columnDefinition="ENUM('Simple', 'Absolue', 'Double', 'Unanimité')")
		 */
		private $type_vote;

		/**
		 * @ORM\Column(type="string", length=60)
		 */
		private $title;

		/**
		 * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="resolution")
		 */
		private $votes;

		public function __construct () {
			$this->votes = new ArrayCollection();
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

		public function getMeeting (): ?Meeting {
			return $this->meeting;
		}

		public function setMeeting (?Meeting $meeting): self {
			$this->meeting = $meeting;

			return $this;
		}

		public function getTypeVote (): ?int {
			return $this->type_vote;
		}

		public function setTypeVote (int $type_vote): self {
			$this->type_vote = $type_vote;

			return $this;
		}

		public function getTitle (): ?string {
			return $this->title;
		}

		public function setTitle (string $title): self {
			$this->title = $title;

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
				$vote->setResolution($this);
			}

			return $this;
		}

		public function removeVote (Vote $vote): self {
			if ($this->votes->contains($vote)) {
				$this->votes->removeElement($vote);
				// set the owning side to null (unless already changed)
				if ($vote->getResolution() === $this) {
					$vote->setResolution(null);
				}
			}

			return $this;
		}
	}