<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\DelegationRepository")
	 */
	class Delegation {
		/**
		 * @ORM\Id()
		 * @ORM\GeneratedValue()
		 * @ORM\Column(type="integer")
		 */
		private $id;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Meeting", inversedBy="delegations")
		 */
		private $meeting;

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $uuid;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\Owner", cascade={"persist", "remove"})
		 */
		private $donor_owner;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\Owner", cascade={"persist", "remove"})
		 */
		private $receiver_owner;

		public function getId (): ?int {
			return $this->id;
		}

		public function getMeeting (): ?Meeting {
			return $this->meeting;
		}

		public function setMeeting (?Meeting $meeting): self {
			$this->meeting = $meeting;

			return $this;
		}

		public function getUuid (): ?string {
			return $this->uuid;
		}

		public function setUuid (string $uuid): self {
			$this->uuid = $uuid;

			return $this;
		}

		public function getDonorOwner (): ?Owner {
			return $this->donor_owner;
		}

		public function setDonorOwner (?Owner $donor_owner): self {
			$this->donor_owner = $donor_owner;

			return $this;
		}

		public function getReceiverOwner (): ?Owner {
			return $this->receiver_owner;
		}

		public function setReceiverOwner (?Owner $receiver_owner): self {
			$this->receiver_owner = $receiver_owner;

			return $this;
		}
	}
