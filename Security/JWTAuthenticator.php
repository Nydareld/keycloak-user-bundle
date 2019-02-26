<?php

namespace Nydareld\KeycloakUserBundle\Security;

use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class JWTAuthenticator extends AbstractGuardAuthenticator{

    public function getCredentials(Request $request){
        dump("getCredentials");
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($request);

        if (!$token) {
            return;
        }
        dump( $token);
        return $token;

    }

    public function supports(Request $request){
        // dump("supports");
        return $request->headers->has('Authorization');
    }

    public function getUser($credentials, UserProviderInterface $userProvider){
        dump("getUser");
        // TODO: Implement getUser() method.
    }

    public function checkCredentials($credentials, UserInterface $user){
        dump("checkCredentials");
        // TODO: Implement checkCredentials() method.
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        dump("onAuthenticationFailure");
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey){
        dump("onAuthenticationSuccess");
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function supportsRememberMe(){
        dump("supportsRememberMe");
        // TODO: Implement supportsRememberMe() method.
    }

    public function start(Request $request, AuthenticationException $authException = null){
        dump("start");
        // TODO: Implement start() method.
    }

}
