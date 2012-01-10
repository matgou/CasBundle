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

namespace Gorg\Bundle\AuthentificatorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ClassLoader\UniversalClassLoader;

class CASAuthentificatorController extends GorgAuthentificatorController
{
    /**
     * Lautch login
     */
    public function loginAction(Request $request)
    {
	require_once(dirname(__FILE__) . '/../lib/cas/CAS.php');
        $cas_server = $this->getParameter('gorg_authentificator.cas_server');
        $cas_port   = $this->getParameter('gorg_authentificator.cas_port');
        $cas_path   = $this->getParameter('gorg_authentificator.cas_path');
	$ca_cert    = $this->getParameter('gorg_authentificator.ca_cert');
        \phpCAS::client(SAML_VERSION_1_1, $cas_server, $cas_port, $cas_path, false);
	
	\phpCAS::setCasServerCACert($ca_cert);
        \phpCAS::forceAuthentication();
	return $this->render('GorgAuthentificatorBundle:CASAuthentificator:login.html.twig', array());
    }

    /**
     * Logout
     */
    public function logoutAction(Request $request)
    {
    }
}
/* vim:set et sw=4 sts=4 ts=4: */
