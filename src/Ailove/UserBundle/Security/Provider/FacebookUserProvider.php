<?php

namespace Ailove\UserBundle\Security\Provider;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FacebookUserProvider implements OAuthAwareUserProviderInterface, UserProviderInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritDoc}
     */
    public function connect($user, UserResponseInterface $response)
    {
        $username = $response->getUsername();

        // 'disconnect' a previous account
        if (null !== $previousUser = $this->userManager->findUserBy(array('facebookUid' => $username))) {
            $previousUser->setFacebookUid(null);
            $this->userManager->updateUser($previousUser);
        }

        $user->setFacebookUid($username);

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array('facebookUid' => $username));

        if (!$user) {
            throw new AccountNotLinkedException(sprintf('No user with facebook username "%s" was found.', $username));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($usernameOrEmail)
    {
        $user = $this->userManager->findUserByUsernameOrEmail($usernameOrEmail);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('No user with name or email "%s" was found.', $usernameOrEmail));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->userManager->refreshUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $this->userManager->supportsClass($class);
    }
}
