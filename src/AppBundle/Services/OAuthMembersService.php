<?php 

namespace AppBundle\Services;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use AppBundle\Security\OAuthUser;

class OAuthMembersService implements UserProviderInterface, OAuthAwareUserProviderInterface {

    public function loadUserByUsername($username) {
		throw new Exception('loadByUsername not implemented');
    }
	
    public function supportsClass($class) {
		return $class === 'AppBundle\\Security\\OAuthUser';
    }
	
	public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user) {
		if (!$this->supportsClass(get_class($user))) {
			throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
		}
		return $user;
	}
	
    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
		return new OAuthUser($response);
    }
	
}