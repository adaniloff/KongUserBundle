<?php
/** Namespace */
namespace Adaniloff\KongUserBundle\Service;

/** Usages */

/**
 * Class Configuration
 * @package Adaniloff\KongUserBundleUser\Service
 */
class Configuration
{
    const AUTH_TYPE_BASIC = 'basic-auths';
    const AUTH_TYPE_KEY   = 'key-auths';

    const AUTH_TYPES = [
        self::AUTH_TYPE_BASIC,
        self::AUTH_TYPE_KEY,
    ];

    /**
     * @var array
     */
    private $config;

    /**
     * Configuration constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function has()
    {
        $args = func_get_args();

        if (!count($args)) {
            throw new \InvalidArgumentException("You must provide at least one argument.");
        }

        $config = $this->config;
        foreach ($args as $arg) {
            if (!is_array($config) or !isset($config[$arg])) {
                return false;
            }
            $config = $config[$arg];
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $args = func_get_args();

        if (!count($args)) {
            throw new \InvalidArgumentException("You must provide at least one argument.");
        }

        $data = $this->config;
        foreach ($args as $arg) {
            if (!is_array($data) or !isset($data[$arg])) {
                throw new \InvalidArgumentException("Key $arg not found in config.");
            }
            $data = $data[$arg];
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->get('kong_host');
    }

    /**
     * @return string
     */
    public function getAuthType()
    {
        return $this->get('auth', 'type');
    }
}
