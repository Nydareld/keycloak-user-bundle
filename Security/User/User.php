<?php

namespace Nydareld\KeycloakUserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface ;

class User implements UserInterface
{
    private $roles;

    private $jwt;

    private $preferred_username;
    private $locale;
    private $given_name;
    private $family_name;
    private $email;
    private $name;
    private $email_verified;

    public function __construct(Array $tokenArray){

        $this->parsedToken = $tokenArray["parsed"];
        $this->jwt = $tokenArray["jwt"];

        $this->roles = [];

        $this->preferred_username = $this->parsedToken->preferred_username;
        $this->locale = $this->parsedToken->locale;
        $this->given_name = $this->parsedToken->given_name;
        $this->family_name = $this->parsedToken->family_name;
        $this->email = $this->parsedToken->email;
        $this->name = $this->parsedToken->name;
        $this->email_verified = $this->parsedToken->email_verified;

        $this->addRoles($this->parsedToken->realm_access->roles,"realm");
        foreach ($this->parsedToken->resource_access as $ressource => $roles) {
            $this->addRoles($roles->roles,$ressource);
        }
    }

    private function addRoles($rolesArray,$ressource){
        foreach ($rolesArray as $value) {
            $this->roles[] = "ROLE_".$ressource.':'.$value;
        }
    }

    public function getJwt(){
        return $this->jwt;
    }

    public function getParsedToken(){
        return $this->parsedToken;
    }


    /**
     * TODO
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(){
        return $this->roles;
    }
    /**
     * TODO
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(){

    }
    /**
     * TODO
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(){

    }
    /**
     * TODO
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(){
        return $this->preferred_username;
    }
    /**
     * TODO
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(){

    }
}
