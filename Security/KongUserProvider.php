<?php
/** Namespace */
namespace Adaniloff\KongUserBundle\Security;

/** Usages */
use Adaniloff\KongUserBundle\Entity\KongUser;
use Adaniloff\KongUserBundle\Service\KongApi;
use Adaniloff\KongUserBundle\Service\KongHeaderBag;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class KongUserProvider
 * @package Adaniloff\KongUserBundleUser\Security
 */
class KongUserProvider implements UserProviderInterface
{
    /**
     * @var KongHeaderBag
     */
    private $bag;

    /**
     * @var KongApi
     */
    private $api;

    /**
     * KongUserProvider constructor.
     * @param KongHeaderBag $bag
     * @param KongApi $api
     */
    public function __construct(KongHeaderBag $bag, KongApi $api)
    {
        $this->bag = $bag;
        $this->api = $api;
    }

    /**
     * @param string $username
     * @return KongUser|UserInterface
     */
    public function loadUserByUsername($username): KongUser
    {
        return $this->fetchUser($username);
    }

    /**
     * @param UserInterface $user
     * @return KongUser|UserInterface
     */
    public function refreshUser(UserInterface $user): KongUser
    {
        if (!$user instanceof KongUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->fetchUser($user->getUsername());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return KongUser::class === $class;
    }

    /**
     * @param $username
     * @return KongUser
     */
    private function fetchUser($username): KongUser
    {
        $consumer = $this->api->shouldFetchConsumer() ?: $this->api->getConsumer($username);

        if ($consumer) {
            $user = new KongUser(
                $username,
                null,
                null,
                [-1 => KongUser::ROLE_DEFAULT] + (array)$this->bag->getUserRoles(),
                $this->bag->getUserGroups()
            );

            return $user;
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }
}
