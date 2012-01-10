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

use Symfony\Component\DependencyInjection\ContainerAware;

class GorgAuthentificatorController extends ContainerAware
{
    /**
     * render a view to pass
     * @param $view string representing view to render
     * @param $parameters 
     */
    protected function render($view, array $parameters)
    {
        return $this
            ->container
            ->get('templating')
            ->renderResponse($view, $parameters)
        ;
    }

    /**
     * log a info message
     * @param $message message to log
     */
    public function logInfo($message)
    {
        return $this
            ->container
            ->get('logger')
            ->info($message)
        ;
    }

    /**
     * Return a config parameters
     * @param $name parmeter's name
     */
    public function getParameter($name)
    {
	return $this->container->getParameter($name);
    }
}
/* vim:set et sw=4 sts=4 ts=4: */