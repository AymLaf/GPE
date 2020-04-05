<?php

	namespace App\Controller\BO;

	use App\Form\Factory\LoginFormFactory;
	use Exception;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

	class AuthenticationController extends AbstractController {
		/**
		 * @Route("/", name="bo_login")
		 * @param LoginFormFactory $formFactory
		 * @return Response
		 */
		public function login (LoginFormFactory $formFactory): Response {
			 if ($this->getUser()) {
			     return $this->redirectToRoute('bo_dashboard');
			 }
			
			 $form = $formFactory->createForm();
			 
			return $this->render('Authentication/login.html.twig', [
				'form' => $form->createView()
			]);
		}

		/**
		 * @Route("/logout", name="bo_logout")
		 * @throws Exception
		 */
		public function logout () {
			return $this->redirectToRoute('bo_login');
		}
	}
