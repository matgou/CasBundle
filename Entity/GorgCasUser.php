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

namespace Gorg\Bundle\CasBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GorgCasUser a class representing a User 
 * @ORM\Table()
 * @ORM\Entity()
 */
class GorgCasUser implements \Serializable, UserInterface
{

    /**
     * Uniq string to identify a user
     * @ORM\Column(name = "hruid", type = "string", length = 255, nullable = false, unique = true)
     * @ORM\Id
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $hruid = null;

    /**
     * Array to contains data of user
     */
    private $data = array();

    /**
     * return null (no password for cas)
     */
    public function getPassword()
    {
      return null;
    }

    /**
     *  return null (no salt for cas)
     */
    public function getSalt()
    {
      return null;
    }

    /**
     *  return null (no sensitive data for GorgCasUser)
     */
    public function eraseCredentials()
    {
      return null;
    }

    /**
     * Return the username (mostly the hruid field)
     */
    public function getUsername()
    {
        if(isset($this->username)){
            return $this->username;
        }
        return $this->hruid;
    }

    /**
     * Return true if username are same
     */
    public function equals(UserInterface $user)
    {
        return (strcmp($user->getUsername(), $this->getUsername())==0);
    }
    
    /**
     * Serializing CasUser
     * @param string $serialized
     */
    public function serialize() 
    {
	$classData = array(
		'hruid' => $this->hruid,
		'data' => $this->data,
	);
	return serialize($classData);
    }

    /**
     * Unserializing CasUser
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
	$classData = unserialize($serialized);
	$this->data = $classData['data'];
	$this->hruid = $classData['hruid'];
    }

    /**
     * Return user role
     */
    public function getRoles()
    {
	return array('ROLE_ADMIN','ROLE_USER');
    }

    /**
     * Set hruid
     *
     * @param string $hruid
     */
    public function setHruid($hruid)
    {
        $this->hruid = $hruid;
    }

    /**
     * Set a variable
     * @param string $name
     * @param $value
     */
    public function set($name, $value)
    {
	$this->data[$name] = $value;
    }

    /**
     * Overide all Getter 
     * @param $name 
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * return true if variable exist
     * @param $name
     */
    public function __isset($name)
    {
        return property_exists($this, $name) || isset($this->data[$name]);
    }

    /**
     * Destroy variable 
     * @param $name
     */
    public function __unset($name)
    {
        if (property_exists($this, $name)) {
           $this->$name = null;
        } else {
           unset($this->data[$name]);
        }
    }
}
