<?php

namespace Gorg\Bundle\AuthentificatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AuthentificatorController extends Controller
{
    /**
     * Lautch login
     *
     * @Route("/login")
     */
    public function loginAction(Request $request)
    {
        require_once(dirname(__FILE__).'/../CAS/CAS.php');
	\phpCAS::setDebug();
        \phpCAS::client(SAML_VERSION_1_1, 'auth.gadz.org', 443, '/cas/', false);
        $logger = $this->get('logger');
        $logger->info('Login: about to force auth');
        \phpCAS::setNoCasServerValidation();
        \phpCAS::forceAuthentication();
        $logger->info('Login: auth is good');
	$infos = \phpCAS::getAttributes();	
        $token = new UsernamePasswordToken(
            $infos['username'],
            "notset",
            'main',
            array('user'));
        $this->get('security.context')->setToken($token);
        $logger->info(sprintf('User %s login', $infos['username']));

        return new Response('<html><body>'.htmlentities(var_dump(\phpCAS::getAttributes())).'</body></html>');

    }

    /**
     * Logout
     *
     * @Route("/logout")
     */
    public function logoutAction(Request $request)
    {
#        $$this->get('logger')->info(sprintf('Login: logout %s',$this->get('security.context')->getToken()->getUser()));
        $this->get('security.context')->setToken(null);
        require_once(dirname(__FILE__).'/../CAS/CAS.php');
        \phpCAS::client(CAS_VERSION_2_0, 'auth.gadz.org', 443, '/cas/', false);
        \phpCAS::logout();
    }
}
