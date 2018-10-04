<?php

namespace Adaniloff\KongUserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('adaniloff_kong_user');

        $rootNode
            ->children()
                ->scalarNode('kong_host')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->defaultValue('http://127.0.0.1:8001')
                    ->info('The kong host you want to hit.')
                ->end()
                ->arrayNode('auth')
                    ->cannotBeEmpty()
                    ->isRequired()
                    ->children()
                        ->enumNode('type')
                            ->values(\Adaniloff\KongUserBundle\Service\Configuration::AUTH_TYPES)
                            ->defaultValue(\Adaniloff\KongUserBundle\Service\Configuration::AUTH_TYPE_KEY)
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('The auth type you want to use.')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
