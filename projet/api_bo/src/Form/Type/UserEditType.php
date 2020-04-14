<?php
	/**
	 * Created by PhpStorm.
	 * User: mauny_g
	 * Date: 14/04/2020
	 * Time: 00:01
	 */

	namespace App\Form\Type;

	use App\Entity\Owner;
	use App\Entity\Syndic;
	use App\Entity\User;
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\IntegerType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class UserEditType extends AbstractType {
		public function buildForm (FormBuilderInterface $builder, array $options) {
			$builder->add('email', EmailType::class, [
				'label' => 'user.email',
				'translation_domain' => 'common',
				'required' => false
			])
				->add('phoneNumber', IntegerType::class, [
					'label' => 'user.phone',
					'translation_domain' => 'common',
					'required' => false
				])
				->add('owner', EntityType::class, [
					'label' => 'owner.owner',
					'translation_domain' => 'common',
					'class' => Owner::class,
					'placeholder' => 'menu.choose_owner',
					'required' => false
				])
				->add('syndic', EntityType::class, [
					'label' => 'syndic.syndic',
					'translation_domain' => 'common',
					'class' => Syndic::class,
					'placeholder' => 'menu.choose_syndic',
					'required' => false
				])
				->add('submit', SubmitType::class, [
					'label' => 'menu.edit',
					'translation_domain' => 'common'
				]);
		}

		/**
		 * @param OptionsResolver $resolver
		 */
		public function configureOptions (OptionsResolver $resolver) {
			$resolver->setDefaults([
				'data_class' => User::class
			]);
		}
	}