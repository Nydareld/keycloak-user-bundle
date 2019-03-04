<?php

namespace Nydareld\KeycloakUserBundle\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;


use Symfony\Component\Cache\Simple\AbstractCache;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Unirest\Request;

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

        $key =  $this->getKey();

        $decoded = JWT::decode($token,$key, array('RS256'));

        return $decoded;

    }

    function getKey(){
        if (!$this->cache->has('nydareld_keycloak_user.jwks_configuration')) {
            $this->cacheJWKS();
        }
        return JWK::parseKeySet($this->cache->get('nydareld_keycloak_user.jwks_configuration'));
    }

    function cacheJWKS(){

        // get openid configuration
        $response = Request::get($this->openidConfifgurationEndpoint);
        if( $response->code >= 400 ){
            throw new HttpException(500,"Keycloak openid endpoint error");
        }

        // get jwks configuration
        $response = Request::get($response->body->jwks_uri);
        if( $response->code >= 400 ){
            throw new HttpException(500,"Keycloak openid endpoint error");
        }

        // cahe jwks configuration
        $this->cache->set('nydareld_keycloak_user.jwks_configuration', $response->raw_body, $this->cacheTtl);

    }


}
