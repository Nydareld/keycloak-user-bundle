<?php

namespace Nydareld\KeycloakUserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('keycloak_user');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('realm')->defaultValue("master")->end()
                        ->scalarNode('url')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('clientId')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()


        ;

        return $treeBuilder;
    }
}
