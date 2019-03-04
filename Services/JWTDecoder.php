<?php

namespace Nydareld\KeycloakUserBundle\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;

use Symfony\Component\Cache\Simple\AbstractCache;
use Symfony\Component\Cache\Simple\FilesystemCache;

class JWTDecoder {

    protected $openidConfifgurationEndpoint;
    protected $cache;
    protected $cacheTtl;

    public function __construct(String $openidConfifgurationEndpoint, AbstractCache $cacheProvider = null, $cacheTtl = 3600)
    {
        if(is_null($cacheProvider)){
            $cacheProvider = new FilesystemCache();
        }
        $this->cache = $cacheProvider;
        $this->cacheTtl = $cacheTtl;
        $this->openidConfifgurationEndpoint = $openidConfifgurationEndpoint;
    }

    function decode($token){

        $key =  $this->getKey() ;
        $decoded = JWT::decode($token,$key, array('RS256'));

    }

    function getKey(){
        if (!$this->cache->has('nydareld_keycloak_user.jwks_configuration')) {
            $this->cacheJWKS();
        }
        return JWK::parseKeySet($this->cache->get('nydareld_keycloak_user.jwks_configuration'));
    }

    function cacheJWKS(){
        dump("pas de value");

        $value = '{"keys":[{"kid":"N35AFy2AVcge7EtbpYexo5Shth9YrN2RkPO9g_RIc54","kty":"RSA","alg":"RS256","use":"sig","n":"s8OvdMOgdD3x2QB6w8FjIogdMc0S4GLqRoDE_lAdrKRVWOK5NNkhs80ZK4z_vdHUMNs94oBk_gcUwagkw_vgW1qQtQVXJQxQMmlhUXSgI1QlPUdT6xnPF5HWNJCDkEu3deaeHcw6EE6BKkuZyI88F0YvnexZ2W_QPrDKwi8Rhgn1ii6P2Q6_wlkgeKERo32AK0K2_C4VZfwTFrkJWhpmt-wb0LIkPtd0m2qI22DhB2gO4e5UXUNwcqTM35jdD62nh0nzDaSZFLADy0Nb_jbZlcmma6mIXd6s4nl6e5qEqL4a3iwgODWP74PaQ12KHOMBWlE-DC_aodzS6kUFpZg3ZQ","e":"AQAB"}]}';

        $this->cache->set('nydareld_keycloak_user.jwks_configuration', $value, $this->cacheTtl);

    }

}
