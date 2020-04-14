<?php
	/**
	 * Created by PhpStorm.
	 * User: mauny_g
	 * Date: 10/04/2020
	 * Time: 18:38
	 */

	namespace App\Controller\BO;

	use App\Entity\User;
	use App\Form\Type\UserEditType;
	use App\Repository\UserRepository;
	use Knp\Component\Pager\PaginatorInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Contracts\Translation\TranslatorInterface;

	/**
	 * Class UsersController
	 * @package App\Controller\BO
	 * @Route("/dashboard/users")
	 */
	class UsersController extends AbstractController {
		/** @var UserRepository $userRepository */
		private $userRepository;
		/** @var TranslatorInterface $translator */
		private $translator;
		/** @var PaginatorInterface */
		private $paginator;

		public function __construct (UserRepository $userRepository, TranslatorInterface $translator, PaginatorInterface $paginator) {
			$this->userRepository = $userRepository;
			$this->translator = $translator;
			$this->paginator = $paginator;
		}

		/**
		 * @Route("/{id}/show", name="user_show")
		 * @param Request $request
		 * @param integer $id
		 * @return Response
		 */
		public function show(Request $request, int $id) {
			$user = $this->userRepository->find($id);
			if (!($user instanceof User)) {
				$this->addFlash('danger', $this->translator->trans('user.user_not_found_error', [], 'common'));
				return $this->redirectToRoute('users_list');
			}

			return $this->render('Users/show.html.twig', [
				'user' => $user
			]);
		}

		/**
		 * @Route("/{id}/edit", name="user_edit")
		 * @param Request $request
		 * @param integer $id
		 * @return RedirectResponse|Response
		 */
		public function edit(Request $request, int $id) {
			$user = $this->userRepository->find($id);

			if ($user instanceof User) {
				$form = $this->createForm(UserEditType::class, $user);

				$form->handleRequest($request);
				if ($form->isSubmitted() && $form->isValid()) {
					$userEdited = $form->getData();
					//TODO Call le service qui devra gérer les creations/modifs/suppressions relatives aux entités

					$this->addFlash('success', $this->translator->trans('user.user_success_edit', [], 'common'));
					return $this->redirectToRoute('user_show', [
						'id' => $user->getId()
					]);
				}

				return $this->render('Users/edit.html.twig', [
					'form' => $form->createView()
				]);
			} else {
				$this->addFlash('danger', $this->translator->trans('user.user_not_found_error', [], 'common'));
			}

			return $this->redirectToRoute('users_list');
		}

		/**
		 * @Route("/{id}/remove", name="user_remove")
		 * @param Request $request
		 * @param integer $id
		 * @return RedirectResponse
		 */
		public function remove(Request $request, int $id) {
			$user = $this->userRepository->find($id);
			if ($user instanceof User) {
				if ($user === $this->getUser()) {
					$this->addFlash('danger', $this->translator->trans('user.user_error_not_remove_yourself', [], 'common'));
				} else {
					//TODO Call le service qui devra gérer les creations/modifs/suppressions relatives aux entités
					$this->addFlash('success', $this->translator->trans('user.user_success_remove', [], 'common'));
				}
			} else {
				$this->addFlash('danger', $this->translator->trans('user.user_not_found_error', [], 'common'));
			}
			return $this->redirectToRoute('users_list');
		}

		/**
		 * @Route("/list", name="users_list")
		 * @param Request $request
		 * @return Response
		 */
		public function list(Request $request) {
			$users = $this->paginator->paginate(
				$this->userRepository->listAll(),
				$request->query->getInt('page', 1),
				15
			);

			return $this->render("Users/list.html.twig", [
				'users' => $users
			]);
		}
	}