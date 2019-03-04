<?php

namespace Nydareld\KeycloakUserBundle\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;

use Symfony\Component\Cache\Simple\AbstractCache;

class JWTDecoder {

    protected $openidConfifgurationEndpoint;
    protected $cache;

    public function __construct(String $openidConfifgurationEndpoint, $cacheProvider = null)
    {
        dump($cacheProvider);
        $this->openidConfifgurationEndpoint = $openidConfifgurationEndpoint;
    }

    function decode($token){


        $key = JWK::parseKeySet($this->getJwksConfiguration());

        $decoded = JWT::decode($token, $key , array('RS256'));

    }

    function getJwksConfiguration(){
        return '{"keys":[{"kid":"N35AFy2AVcge7EtbpYexo5Shth9YrN2RkPO9g_RIc54","kty":"RSA","alg":"RS256","use":"sig","n":"s8OvdMOgdD3x2QB6w8FjIogdMc0S4GLqRoDE_lAdrKRVWOK5NNkhs80ZK4z_vdHUMNs94oBk_gcUwagkw_vgW1qQtQVXJQxQMmlhUXSgI1QlPUdT6xnPF5HWNJCDkEu3deaeHcw6EE6BKkuZyI88F0YvnexZ2W_QPrDKwi8Rhgn1ii6P2Q6_wlkgeKERo32AK0K2_C4VZfwTFrkJWhpmt-wb0LIkPtd0m2qI22DhB2gO4e5UXUNwcqTM35jdD62nh0nzDaSZFLADy0Nb_jbZlcmma6mIXd6s4nl6e5qEqL4a3iwgODWP74PaQ12KHOMBWlE-DC_aodzS6kUFpZg3ZQ","e":"AQAB"}]}';
    }

}
