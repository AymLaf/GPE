<?php
	/**
	 * Created by PhpStorm.
	 * User: mauny_g
	 * Date: 10/04/2020
	 * Time: 18:38
	 */

	namespace App\Controller\BO;

	use App\Entity\User;
	use App\Repository\UserRepository;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Contracts\Translation\TranslatorInterface;

	/**
	 * Class UsersController
	 * @package App\Controller\BO
	 * @Route("/dashboard/user")
	 */
	class UsersController extends AbstractController {
		/** @var UserRepository $userRepository */
		private $userRepository;
		/** @var TranslatorInterface $translator */
		private $translator;

		public function __construct (UserRepository $userRepository, TranslatorInterface $translator) {
			$this->userRepository = $userRepository;
			$this->translator = $translator;
		}

		/**
		 * @Route("/{id}/show", name="user_show")
		 * @param Request $request
		 * @param $id
		 * @return Response
		 */
		public function show(Request $request, $id) {
			$user = $this->userRepository->find($id);
			if ($user instanceof User) {
				return $this->render('Users/show.html.twig', [
					'user' => $user
				]);
			} else {
				$this->addFlash('danger', $this->translator->trans('user.user_not_found_error', [], 'common'));
				return $this->redirectToRoute('users_list');
			}
		}

		/**
		 * @Route("/list", name="users_list")
		 * @param Request $request
		 * @return Response
		 */
		public function list(Request $request) {
			$users = $this->userRepository->findAll();

			return $this->render("Users/list.html.twig", [
				'users' => $users
			]);
		}
	}