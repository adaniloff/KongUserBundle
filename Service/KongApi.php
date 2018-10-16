<?php
/** Namespace */
namespace Adaniloff\KongUserBundle\Service;

/** Usages */
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class KongApi
 * @package Adaniloff\KongUserBundleUser\Service
 */
class KongApi
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * KongApi constructor.
     * @param Client $client
     * @param Configuration $configuration
     */
    public function __construct(Client $client, Configuration $configuration)
    {
        $this->client        = $client;
        $this->configuration = $configuration;
    }

    /**
     * @return bool
     */
    public function shouldFetchConsumer(): bool
    {
        return false === $this->configuration->has('auth');
    }

    /**
     * @param string $username
     * @return \stdClass|null
     */
    public function getConsumer(string $username): ?\stdClass
    {
        try {
            $response = $this->client->get($this->configuration->getHostPrefix() . "/consumers/$username");
        } catch (RequestException $exception) {
            error_log($exception->getMessage());

            return null;
        }

        return json_decode($response->getBody()->getContents());
    }
}
