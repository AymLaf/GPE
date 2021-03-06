<?php

	namespace App\Security\BO;

	use App\Entity\User;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
	use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
	use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
	use Symfony\Component\Security\Csrf\CsrfToken;
	use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
	use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
	use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
	use Symfony\Component\Security\Http\Util\TargetPathTrait;
	use Symfony\Contracts\Translation\TranslatorInterface;

	/**
	 * Class LoginAuthenticator
	 * @package App\Security\BO
	 */
	class LoginAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface {
		use TargetPathTrait;

		private $entityManager;
		private $urlGenerator;
		private $csrfTokenManager;
		private $passwordEncoder;
		private $translator;

		/**
		 * LoginAuthenticator constructor.
		 * @param EntityManagerInterface $entityManager
		 * @param UrlGeneratorInterface $urlGenerator
		 * @param CsrfTokenManagerInterface $csrfTokenManager
		 * @param UserPasswordEncoderInterface $passwordEncoder
		 * @param TranslatorInterface $translator
		 */
		public function __construct (EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, TranslatorInterface $translator) {
			$this->entityManager = $entityManager;
			$this->urlGenerator = $urlGenerator;
			$this->csrfTokenManager = $csrfTokenManager;
			$this->passwordEncoder = $passwordEncoder;
			$this->translator = $translator;
		}

		/**
		 * @param Request $request
		 * @return bool
		 */
		public function supports (Request $request) {
			return 'bo_login' === $request->attributes->get('_route') && $request->isMethod('POST');
		}

		/**
		 * @param Request $request
		 * @return array|mixed
		 */
		public function getCredentials (Request $request) {
			$credentials = ['email' => $request->request->get('email'), 'password' => $request->request->get('password'), 'csrf_token' => $request->request->get('_csrf_token'),];
			$request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

			return $credentials;
		}

		/**
		 * @param mixed $credentials
		 * @param UserProviderInterface $userProvider
		 * @return User|object|UserInterface|null
		 */
		public function getUser ($credentials, UserProviderInterface $userProvider) {
			$token = new CsrfToken('authenticate', $credentials['csrf_token']);
			if (!$this->csrfTokenManager->isTokenValid($token)) {
				throw new InvalidCsrfTokenException();
			}

			$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

			if (!$user) {
				throw new CustomUserMessageAuthenticationException($this->translator->trans('menu.invalid_credentials', [], 'common'));
			}

			return $user;
		}

		/**
		 * @param mixed $credentials
		 * @param UserInterface $user
		 * @return bool
		 */
		public function checkCredentials ($credentials, UserInterface $user) {
			if (!$this->passwordEncoder->isPasswordValid($user, $credentials['password'])) {
				throw new CustomUserMessageAuthenticationException($this->translator->trans('menu.invalid_credentials', [], 'common'));
			}

			return true;
		}

		/**
		 * @param mixed $credentials
		 * @return string|null
		 */
		public function getPassword ($credentials): ?string {
			return $credentials['password'];
		}

		public function onAuthenticationSuccess (Request $request, TokenInterface $token, $providerKey) {
			if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
				return new RedirectResponse($targetPath);
			}

			return new RedirectResponse($this->urlGenerator->generate('bo_dashboard'));
		}

		/**
		 * @return string
		 */
		protected function getLoginUrl () {
			return $this->urlGenerator->generate('bo_login');
		}
	}
