<?php

namespace Nydareld\KeycloakUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Nydareld\KeycloakUserBundle\DependencyInjection\KeycloakUserExtension;


class KeycloakUserBundle extends Bundle
{

    public function getContainerExtension()
    {
        return new KeycloakUserExtension();
    }
}
