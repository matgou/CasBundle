<?php
/***************************************************************************
 * Copyright (C) 1999-2011 Gadz.org                                        *
 * http://opensource.gadz.org/                                             *
 *                                                                         *
 * This program is free software; you can redistribute it and/or modify    *
 * it under the terms of the GNU General Public License as published by    *
 * the Free Software Foundation; either version 2 of the License, or       *
 * (at your option) any later version.                                     *
 *                                                                         *
 * This program is distributed in the hope that it will be useful,         *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the            *
 * GNU General Public License for more details.                            *
 *                                                                         *
 * You should have received a copy of the GNU General Public License       *
 * along with this program; if not, write to the Free Software             *
 * Foundation, Inc.,                                                       *
 * 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA                   *
 ***************************************************************************/

namespace Gorg\Bundle\CasBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Gorg\Bundle\CasBundle\Security\Authentication\Token\GorgUserToken;

class GorgListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;
    private   $cas_server;
    private   $cas_port;
    private   $cas_path;
    private   $ca_cert;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager,
				$cas_server, $cas_port, $cas_path, $ca_cert)
    {
        $this->cas_server = $cas_server;
        $this->cas_port   = $cas_port;
        $this->cas_path   = $cas_path;
        $this->ca_cert    = $ca_cert;
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        require_once(dirname(__FILE__) . '/../../lib/cas/CAS.php');
        \phpCAS::client(SAML_VERSION_1_1, $this->cas_server, $this->cas_port, $this->cas_path, false);

        \phpCAS::setCasServerCACert($this->ca_cert);
        \phpCAS::forceAuthentication();
	$attributes = \phpCAS::getAttributes();

        if (!$attributes['username']) {
            return;
        }

        $token = new GorgUserToken();
        $token->setUser($attributes['username']);
        try {
            $returnValue = $this->authenticationManager->authenticate($token);
            if ($returnValue instanceof TokenInterface) {
                return $this->securityContext->setToken($returnValue);
            } else if ($returnValue instanceof Response) {
                return $event->setResponse($returnValue);
            }
        } catch (AuthenticationException $e) {
                // you might log something here
        }
        
        $response = new Response();
        $response->setStatusCode(403);
        $event->setResponse($response);
    }
}

/* vim:set et sw=4 sts=4 ts=4: */
