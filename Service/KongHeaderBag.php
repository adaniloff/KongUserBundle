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
        return (array)$this->request->headers->get(self::HEADER_GROUPS, null);
    }
}
