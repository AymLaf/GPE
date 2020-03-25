<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\LotRepository")
	 */
	class Lot {
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
		 * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="lots")
		 */
		private $owner;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="lots")
		 */
		private $building;

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

		public function getOwner (): ?Owner {
			return $this->owner;
		}

		public function setOwner (?Owner $owner): self {
			$this->owner = $owner;

			return $this;
		}

		public function getBuilding (): ?Building {
			return $this->building;
		}

		public function setBuilding (?Building $building): self {
			$this->building = $building;

			return $this;
		}
	}
