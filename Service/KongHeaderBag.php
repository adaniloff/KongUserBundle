<?php
/** Namespace */
namespace Adaniloff\KongUserBundle\Service;

/** Usages */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class KongHeaderBag
 * @package Adaniloff\KongUserBundleUser\Service
 */
class KongHeaderBag
{
    const HEADER_GROUPS              = "x-consumer-groups";
    const HEADER_CREDENTIAL_USERNAME = "x-credential-username";
    const HEADER_CONSUMER_USERNAME   = "x-consumer-username";
    const HEADER_CONSUMER_CUSTOM_ID  = "x-consumer-custom-id";
    const HEADER_CONSUMER_ID         = "x-consumer-id";

    /**
     * @var Request
     */
    private $request;

    /**
     * KongApi constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * @param string $header
     * @return string|null
     */
    public function get(string $header): ?string
    {
        return $this->request->headers->get($header, null);
    }

    /**
     * @return array|null
     */
    public function getGroups(): ?array
    {
        return array_map(
            'trim',
            explode(',', $this->get(self::HEADER_GROUPS))
        );
    }

    /**
     * @return null|array
     */
    public function getUserRoles(): ?array
    {
        $groups = $this->filterGroupsByKey('role:');

        if (!count($groups)) {
            return null;
        }

        return $groups;
    }

    /**
     * @return null|array
     */
    public function getUserGroups(): ?array
    {
        $groups = $this->filterGroupsByKey('group:');

        if (!count($groups)) {
            return null;
        }

        return $groups;
    }

    /**
     * @param string $key
     * @return array
     */
    private function filterGroupsByKey($key): array
    {
        $filteredGroups = [];

        foreach ($this->getGroups() as $group) {
            if (0 === strpos($group, $key)) {
                list(,$value) = explode($key, $group);
                $filteredGroups[] = $value;
            }
        }

        return $filteredGroups;
    }
}
