<?php 

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use AppBundle\Entity\User;
use AppBundle\Entity\UserOauth;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
	Symfony\Component\Security\Core\AuthenticationEvents,
	Symfony\Component\Security\Core\Event\AuthenticationEvent;

class SecurityController extends Controller {
	
	protected $oauthDataKey = 'oAuthData';
	
	public function oauthTargetAction() {
		$user = $this->getUser();
		$this->get('session')->getFlashBag()->set($this->oauthDataKey, $user->getData());
		return $this->redirect($this->generateUrl('oauth_register'));
	}
	
	public function oauthRegisterAction() {
		$oAuthData = $this->get('session')->getFlashBag()->get($this->oauthDataKey);
		
		if (!$oAuthData || !is_array($oAuthData) || !isset($oAuthData['provider']) || !isset($oAuthData['providerId']))
			return $this->redirect($this->generateUrl('hwi_oauth_connect'));
		
		// Search for userOauth
		$userOauth = $this->getDoctrine()->getRepository('AppBundle:UserOauth')->findOneBy(array(
			'provider'=>$oAuthData['provider'],
			'providerId'=>$oAuthData['providerId'],
		));
		if ($userOauth) {
			// We found it, update user oauth data
			$this->setUserOauthData($userOauth, $oAuthData);
			$this->getDoctrine()->getManager()->flush();
			
			// Log the user
			$user = $userOauth->getUser();
			$this->logUser($user);
		} else {
			$user = $this->getUser();
			if ($user && is_object($user)) {
				// User is already connected, just add the UserOauth
				$userOauth = $this->getNewUserOauth($user, $oAuthData);
				$this->getDoctrine()->getManager()->flush();
			} else {
				// Not logged and not existing, redirect to register page
				$this->get('session')->getFlashBag()->set($this->oauthDataKey, $oAuthData);
				return $this->redirect($this->generateUrl('register'));
			}
		}
		return $this->redirect($this->generateUrl('homepage'));
	}
	
	/**
	 * Get a new UserOauth entity with persisting it
	 *
	 * @param User $user
	 * @param array $oAuthData
	 * @return UserOauth
	 */
	protected function getNewUserOauth($user, $oAuthData) {
		$userOauth = new UserOauth();
		$userOauth->setUser($user);
		$this->setUserOauthData($userOauth, $oAuthData);
		$this->getDoctrine()->getManager()->persist($userOauth);
		return $userOauth;
	}
	
	protected function setUserOauthData($userOauth, $oAuthData) {
		foreach($oAuthData as $k=>$v) {
			$fct = 'set'.ucfirst($k);
			$userOauth->$fct($v);
		}
	}
	
	public function logUser(User $user) {
		// Here, "main" is the name of the firewall in your security.yml
		$token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
		$this->get('security.context')->setToken($token);

		// Fire the login event
		$this->get('event_dispatcher')->dispatch(AuthenticationEvents::AUTHENTICATION_SUCCESS, new AuthenticationEvent($token));
	}
	
	public function registerAction() {
		$user = new User();
		
		$oAuthData = $this->get('session')->getFlashBag()->get($this->oauthDataKey);
		if ($oAuthData && is_array($oAuthData)) {
			if (isset($oAuthData['email']) && $oAuthData['email'])
				$user->setEmail($oAuthData['email']);
			if (isset($oAuthData['nickname']) && $oAuthData['nickname'])
				$user->setUsername($oAuthData['nickname']);
		} else {
			$oAuthData = false;
		}
		
		$form = $this->createFormBuilder($user)
					// Create your form normally
					->getForm();
		
		$form->handleRequest($this->getRequest());
		if ($form->isValid()) {
			// Handle the user normally, preparing for persistence
			$this->getDoctrine()->getManager()->persist($user);
			
			if ($oAuthData && is_array($oAuthData))
				$userOauth = $this->getNewUserOauth($user, $oAuthData);
				
			$this->getDoctrine()->getManager()->flush();
			$this->logUser($user);
			return $this->redirect($this->generateUrl('homepage'));
		}
		
		// Keep oAuthData in flashbag
		if ($oAuthData)
			$this->get('session')->getFlashBag()->set($this->oauthDataKey, $oAuthData);
		
        return $this->render(
            'AppBundle:Security:register.html.php',
            array(
				'form'=>$form->createView()
			)
        );
	}
	
}