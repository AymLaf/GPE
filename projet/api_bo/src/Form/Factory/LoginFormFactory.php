<?php
	/**
	 * Created by PhpStorm.
	 * User: mauny_g
	 * Date: 05/04/2020
	 * Time: 00:09
	 */

	namespace App\Form\Factory;

	use App\Form\Type\LoginFormType;
	use Symfony\Component\Form\FormError;
	use Symfony\Component\Form\FormFactoryInterface;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

	/**
	 * Class LoginFormFactory
	 * @package App\Form\Factory
	 */
	class LoginFormFactory {
		protected $formFactory;
		protected $authenticationUtils;

		/**
		 * LoginFormFactory constructor.
		 * @param FormFactoryInterface $formFactory
		 * @param AuthenticationUtils $authenticationUtils
		 */
		public function __construct (FormFactoryInterface $formFactory, AuthenticationUtils $authenticationUtils) {
			$this->formFactory = $formFactory;
			$this->authenticationUtils = $authenticationUtils;
		}

		/**
		 * @return FormInterface
		 */
		public function createForm(): FormInterface {
			$form = $this->formFactory->create(LoginFormType::class);
			$form->get('email')->setData($this->authenticationUtils->getLastUsername());

			$error = $this->authenticationUtils->getLastAuthenticationError();

			if ($error) {
				$form->addError(new FormError($error->getMessage()));
			}

			return $form;
		}
	}