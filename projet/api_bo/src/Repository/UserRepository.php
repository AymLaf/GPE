<?php

	namespace App\Repository;

	use App\Entity\User;
	use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
	use Doctrine\Common\Persistence\ManagerRegistry;
	use Doctrine\ORM\Query;
	use Knp\Component\Pager\Pagination\PaginationInterface;
	use Knp\Component\Pager\PaginatorInterface;

	/**
	 * @method User|null find($id, $lockMode = null, $lockVersion = null)
	 * @method User|null findOneBy(array $criteria, array $orderBy = null)
	 * @method User[]    findAll()
	 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
	 */
	class UserRepository extends ServiceEntityRepository {
		public function __construct (ManagerRegistry $registry) {
			parent::__construct($registry, User::class);
		}

		/**
		 * @return Query
		 */
		public function listAll () {
			return $this->createQueryBuilder('u')
				->select('u')
				->leftJoin('u.owner', 'o', 'WITH', 'u.owner = o.id')
				->leftJoin('u.syndic', 's', 'WITH', 'u.syndic = s.id')
				->orderBy('u.email', 'ASC')
				->getQuery();
		}
	}
