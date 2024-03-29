<?php

namespace Nydareld\KeycloakUserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;

class NydareldKeycloakUserExtension extends Extension{

    public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('security.yml');
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if( array_key_exists('credentials',$config) ){
            $definition = $container->getDefinition('nydareld_keycloak_user.user_provider');
            $definition->replaceArgument('$realm', $config['credentials']['realm']);
            $definition->replaceArgument('$url', $config['credentials']['url']);
            $definition->replaceArgument('$clientId', $config['credentials']['clientId']);
    
            if( !isset($config['credentials']['openid_confifguration_endpoint'] ) ){
                $config['credentials']['openid_confifguration_endpoint'] = $config['credentials']['url'].'/realms/'.$config['credentials']['realm'].'/.well-known/openid-configuration';
            }
    
            $definition = $container->getDefinition('nydareld_keycloak_user.jwt_decoder');
            $definition->replaceArgument('$openidConfifgurationEndpoint', $config['credentials']['openid_confifguration_endpoint']);
            if(isset($config['cache_provider'])){
                $definition->replaceArgument('$cacheProvider', $config['cache_provider']);
            }
        }

    }

}
