<?php

	namespace App\Entity;

	use ApiPlatform\Core\Annotation\ApiResource;
    use App\Core\Traits\IdentifierTrait;
    use Doctrine\ORM\Mapping as ORM;
    use Ramsey\Uuid\Uuid;

    /**
	 * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\LotRepository")
	 */
	class Lot {
        use IdentifierTrait;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="lots")
		 */
		private $owner;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="lots")
		 */
		private $building;

        public function __construct()
        {
            $this->setUuid(Uuid::uuid4());
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
