<?php

namespace Nydareld\KeycloakUserBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class KeycloakJsonController extends AbstractController{

    protected $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @Route("/keycloak.json", name="keycloak_json", methods="GET" )
     */
    public function index(){

        return new JsonResponse($this->provider->getJson());

    }

}
