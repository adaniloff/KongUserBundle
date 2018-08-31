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
     * @var Configuration
     */
    private $config;

    /**
     * @var Client
     */
    private $client;

    /**
     * KongApi constructor.
     * @param Configuration $config
     * @param Client $client
     */
    public function __construct(Configuration $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param string $username
     * @return \stdClass|null
     */
    public function getConsumer(string $username): ?\stdClass
    {
        /** @var string $type */
        $type = $this->config->getAuthType();

        try {
            $response = $this->client->get("/$type/$username/consumer");
        } catch (RequestException $exception) {
            error_log($exception->getMessage());

            return null;
        }

        /** @var \stdClass $content */
        return json_decode($response->getBody()->getContents());
    }
}
