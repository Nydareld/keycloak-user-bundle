<?php

namespace Nydareld\KeycloakUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Nydareld\KeycloakUserBundle\DependencyInjection\NydareldKeycloakUserExtension;


class NydareldKeycloakUserBundle extends Bundle
{

    public function getContainerExtension()
    {
        return new NydareldKeycloakUserExtension();
    }
}
