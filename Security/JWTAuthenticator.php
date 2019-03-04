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
        // TODO check la spec
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        // TODO: Implement onAuthenticationFailure() method.
        dump($exception);
        return new JsonResponse([
            "message" => "Access Denied"
        ], Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey){
        return null;
    }

    public function supportsRememberMe(){
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null){
        dump($authException);
        $data = [
            'message' => 'Authentication Required'
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

}
