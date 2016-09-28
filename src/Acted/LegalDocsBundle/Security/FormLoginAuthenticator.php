<?php

namespace Acted\LegalDocsBundle\Security;


use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Security\Exception\ActivationException;
use KnpU\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 09.03.16
 * Time: 16:42
 */
class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                [
                    'artistId' => $token->getUser()->getArtist()->getId(),
                    'userId' => $token->getUser()->getId(),
                    'role' => $token->getUser()->getRoles()
                ]
            );
        }

        return parent::onAuthenticationSuccess($request, $token, $providerKey);
    }

    /**
     * Return the URL to the login page
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->container->get('router')
            ->generate('security_login');
    }

    /**
     * The user will be redirected to the secure page they originally tried
     * to access. But if no such page exists (i.e. the user went to the
     * login page directly), this returns the URL the user should be redirected
     * to after logging in successfully (e.g. your homepage)
     *
     * @return string
     */
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->container->get('router')
            ->generate('acted_legal_docs_homepage');
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array). If you return null, authentication
     * will be skipped.
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/login_check') {
            return null;
        }

        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');
        return [
            'username' => $username,
            'password' => $password
        ];
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];

        try {
            return $userProvider->loadUserByUsername($username);
        } catch(UsernameNotFoundException $e) {
            throw new BadCredentialsException();
        }
    }

    /**
     * Throw an AuthenticationException if the credentials are invalid.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        $encoder = $this->container->get('security.password_encoder');

        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            // throw any AuthenticationException
            throw new BadCredentialsException();
        }

        if($user instanceof User && (!$user->getActive())){
            throw new ActivationException();
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => $exception->getMessageKey()], 403);
        }
        return parent::onAuthenticationFailure($request, $exception);
    }
}