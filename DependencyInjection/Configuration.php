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
                ->arrayNode('kong_host')
                    ->cannotBeEmpty()
                    ->isRequired()
                    ->children()
                        ->scalarNode('url')
                            ->defaultValue('http://127.0.0.1:8001')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('The kong host url you want to hit.')
                        ->end()
                        ->scalarNode('prefix')
                            ->info('Some suffix to append to your host url.')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('auth')
                    ->info('Leave it to null to disable auth checking.')
                    ->cannotBeEmpty()
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
