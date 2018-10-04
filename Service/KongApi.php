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
     * KongApi constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $username
     * @return \stdClass|null
     */
    public function getConsumer(string $username): ?\stdClass
    {
        try {
            $response = $this->client->get("/consumers/$username");
        } catch (RequestException $exception) {
            error_log($exception->getMessage());

            return null;
        }

        return json_decode($response->getBody()->getContents());
    }
}
