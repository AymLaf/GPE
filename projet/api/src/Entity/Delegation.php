<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
    use App\Core\Traits\IdentifierTrait;
    use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\DelegationRepository")
	 */
	class Delegation {
        use IdentifierTrait;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Meeting", inversedBy="delegations")
		 */
		private $meeting;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\Owner", cascade={"persist", "remove"})
		 */
		private $donor_owner;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\Owner", cascade={"persist", "remove"})
		 */
		private $receiver_owner;

		public function getMeeting (): ?Meeting {
			return $this->meeting;
		}

		public function setMeeting (?Meeting $meeting): self {
			$this->meeting = $meeting;

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
