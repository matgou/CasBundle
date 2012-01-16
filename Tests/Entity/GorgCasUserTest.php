<?php
/***************************************************************************
 * Copyright (C) 1999-2012 Gadz.org                                        *
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

namespace Gorg\Bundle\CasBundle\Tests\Entity;

use Gorg\Bundle\CasBundle\Entity\GorgCasUser;

/**
* Test class for User.
*/
class GorgCasUserTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @var User
     */
    protected $object;

    private $serialized;
    
    /**
     * Sets up the fixture, for Userple, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new GorgCasUser();
        $this->object->setHruid('toto.tata.2008');
	$this->object->set('firstname', 'toto');
        $this->object->set('lastname', 'tata');
	$this->serialized = serialize($this->object);
    }

    /**
     * @covers Gorg\Bundle\CasBundle\Entity\GorgCasUser::serialize
     */
    public function testSerialize()
    {	
	$string = serialize($this->object);
	$this->assertRegExp('/toto.tata.2008/',$string);
    }

    /**
     * @covers Gorg\Bundle\CasBundle\Entity\GorgCasUser::unserialize
     */
    public function testGetCreationTime()
    {
	$user = unserialize($this->serialized);
	$this->assertTrue($user->hruid == 'toto.tata.2008');
    }

    /**
     * @covers Gorg\Bundle\CasBundle\Entity\GorgCasUser::getUsername
     */
    public function testGetUsername()
    {
	$this->assertRegExp('/^toto.tata.2008$/', $this->object->getUsername());
    }

    /**
     * @covers Gorg\Bundle\CasBundle\Entity\GorgCasUser::equals
     */
    public function testEquals()
    {
        $user = unserialize($this->serialized);
	$this->assertTrue($user->equals($this->object));
    }

}

