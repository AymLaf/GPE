<?php
	/**
	 * Created by PhpStorm.
	 * User: mauny_g
	 * Date: 04/04/2020
	 * Time: 23:06
	 */

	namespace App\Controller\BO;
	
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;

	/**
	 * Class DefaultController
	 * @package App\Controller\BO
	 */
	class DefaultController extends AbstractController {
		/**
		 * @Route("/dashboard", name="bo_dashboard")
		 * @return Response
		 */
		public function dashboard() {
			return $this->render('Default/dashboard.twig', [
				'controller_name' => 'DefaultController'
			]);
		}
	}