<?php

namespace Nydareld\KeycloakUserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface ;

class KeycloakUserBundle implements UserInterface
{
    private $roles;
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
