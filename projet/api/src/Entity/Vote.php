<?php

	namespace App\Entity;

    use ApiPlatform\Core\Annotation\ApiResource;
    use App\Core\Traits\IdentifierTrait;
    use Doctrine\ORM\Mapping as ORM;

	/**
     * @ApiResource()
	 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
	 */
	class Vote {
        use IdentifierTrait;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="votes")
		 */
		private $owner;

		/**
		 * @ORM\Column(type="string", columnDefinition="ENUM('Pour', 'Contre', 'Neutre')")
		 */
		private $result;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\Resolution", inversedBy="votes")
		 */
		private $resolution;

		public function getOwner (): ?Owner {
			return $this->owner;
		}

		public function setOwner (?Owner $owner): self {
			$this->owner = $owner;

			return $this;
		}

		public function getResult (): ?string {
			return $this->result;
		}

		public function setResult (string $result): self {
			$this->result = $result;

			return $this;
		}

		public function getResolution (): ?Resolution {
			return $this->resolution;
		}

		public function setResolution (?Resolution $resolution): self {
			$this->resolution = $resolution;

			return $this;
		}
	}
