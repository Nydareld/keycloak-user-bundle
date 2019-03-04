<?php

namespace Nydareld\KeycloakUserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('nydareld_keycloak_user');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('realm')->defaultValue("master")->end()
                        ->scalarNode('url')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('clientId')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('openid_confifguration_endpoint')->end()
                    ->end()
                ->end()
                ->scalarNode('cache_provider')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
