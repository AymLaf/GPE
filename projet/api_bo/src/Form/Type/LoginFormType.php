<?php
	/**
	 * Created by PhpStorm.
	 * User: mauny_g
	 * Date: 05/04/2020
	 * Time: 00:10
	 */

	namespace App\Form\Type;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	/**
	 * Class LoginFormType
	 * @package App\Form\Type
	 */
	class LoginFormType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array $options
		 */
		public function buildForm (FormBuilderInterface $builder, array $options) {
			$builder->add('email', EmailType::class, [
					'label' => false,
					'label_attr' => [
						'class' => 'col-sm-1'
					],
					'required' => true,
					'attr' => [
						'placeholder' => 'user.email'
					]
				])
				->add('password', PasswordType::class, [
					'label' => false,
					'label_attr' => [
						'class' => 'col-sm-1'
					],
					'required' => true,
					'attr' => [
						'placeholder' => 'user.password'
					]
				])
				->add('submit', SubmitType::class, [
					'label' => 'menu.login',
					'attr' => [
						'class' => 'btn-lg btn btn-primary'
					]
				]);
		}

		/**
		 * @param OptionsResolver $resolver
		 */
		public function configureOptions (OptionsResolver $resolver) {
			$resolver->setDefaults([
				'translation_domain' => 'common',
				'csrf_field_name' => '_csrf_token',
				'csrf_token_id' => 'authenticate'
			]);
		}

		/**
		 * @return string
		 */
		public function getBlockPrefix () {
			return '';
		}
	}