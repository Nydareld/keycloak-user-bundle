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

        $definition = $container->getDefinition('nydareld_keycloak_user.user_provider');
        $definition->replaceArgument('$realm', $config['credentials']['realm']);
        $definition->replaceArgument('$url', $config['credentials']['url']);
        $definition->replaceArgument('$clientId', $config['credentials']['clientId']);


    }

}
