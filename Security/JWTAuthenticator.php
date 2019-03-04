<?php

namespace Nydareld\KeycloakUserBundle\Security;

use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Nydareld\KeycloakUserBundle\Services\JWTDecoder;

use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Nydareld\KeycloakUserBundle\Security\User\User;

use Firebase\JWT\ExpiredException;

class JWTAuthenticator extends AbstractGuardAuthenticator{

    protected $jwtDecoder;

    public function __construct(JWTDecoder $jwtDecoder)
    {
        $this->jwtDecoder = $jwtDecoder;
    }

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

        return [
            "token"=>$token,
            "parsed"=>$this->jwtDecoder->decode($token)
        ];

    }

    public function supports(Request $request){
        return $request->headers->has('Authorization');
    }

    public function getUser($credentials, UserProviderInterface $userProvider){
        return $userProvider->loadUserByParsedToken($credentials['parsed']);
    }

    public function checkCredentials($credentials, UserInterface $user){
        dump("checkCredentials");
        // TODO: Implement checkCredentials() method.
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        dump("onAuthenticationFailure");
        dump($exception);
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
        dump($authException);
        $data = [
            'message' => 'Authentication Required'
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

}
