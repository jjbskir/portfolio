<?php

namespace classes;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/*
 * Provides the users that are fine to access the admin section.
 */
class UserProvider implements UserProviderInterface
{
    /* @var admin info. */
    private $admin;

    public function __construct($_admin)
    {
        $this->admin = $_admin;
    }
    
    /**
     * @param type $username, username entered into the input field.
     * @return \Symfony\Component\Security\Core\User\User, a user.
     * @throws UsernameNotFoundException 
     * Checks that the username input is an admin and that they entered
     * the correct password.
     */
    public function loadUserByUsername($username)
    { 
        $uname = $this->admin->getUsername();
        
        if ($username != $uname) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return new User($uname, $this->admin->getPassword(), explode(',', $this->admin->getRoles() ), true, true, true, true);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
    
}
?>
