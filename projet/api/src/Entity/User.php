<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
	 */
	class User {
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
		 * @ORM\Column(type="string", length=30)
		 */
		private $role;

		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $email;

		/**
		 * @ORM\Column(type="string", length=50, nullable=true)
		 */
		private $password;

		/**
		 * @ORM\Column(type="string", length=255, nullable=true)
		 */
		private $phone_number;

		/**
		 * @ORM\Column(type="string", length=255, nullable=true)
		 */
		private $verification_id;

		/**
		 * @ORM\Column(type="smallint", nullable=true)
		 */
		private $verified;

		/**
		 * @ORM\Column(type="string", length=255, nullable=true)
		 */
		private $hash;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\Owner", inversedBy="user", cascade={"persist", "remove"})
		 */
		private $owner;

		/**
		 * @ORM\OneToOne(targetEntity="App\Entity\Syndic", inversedBy="user", cascade={"persist", "remove"})
		 */
		private $syndic;

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

		public function getRole (): ?string {
			return $this->role;
		}

		public function setRole (string $role): self {
			$this->role = $role;

			return $this;
		}

		public function getEmail (): ?string {
			return $this->email;
		}

		public function setEmail (string $email): self {
			$this->email = $email;

			return $this;
		}

		public function getPassword (): ?string {
			return $this->password;
		}

		public function setPassword (?string $password): self {
			$this->password = $password;

			return $this;
		}

		public function getPhoneNumber (): ?string {
			return $this->phone_number;
		}

		public function setPhoneNumber (?string $phone_number): self {
			$this->phone_number = $phone_number;

			return $this;
		}

		public function getVerificationId (): ?string {
			return $this->verification_id;
		}

		public function setVerificationId (?string $verification_id): self {
			$this->verification_id = $verification_id;

			return $this;
		}

		public function getVerified (): ?int {
			return $this->verified;
		}

		public function setVerified (?int $verified): self {
			$this->verified = $verified;

			return $this;
		}

		public function getHash (): ?string {
			return $this->hash;
		}

		public function setHash (?string $hash): self {
			$this->hash = $hash;

			return $this;
		}

		public function getOwner (): ?Owner {
			return $this->owner;
		}

		public function setOwner (?Owner $owner): self {
			$this->owner = $owner;

			return $this;
		}

		public function getSyndic (): ?Syndic {
			return $this->syndic;
		}

		public function setSyndic (?Syndic $syndic): self {
			$this->syndic = $syndic;

			return $this;
		}
	}
