<?php

/**
 * Check Class for Access Module
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Access
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\access\classes;

/**
 * Check Class for Access Module
 *
 * @category  Plugins
 * @package   Access
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Check
{
    private $_handler;
    private $_plugin;
    private $_userID;

    public function __construct($plugin, $userID = 0)
    {
        $this->_handler = new Handler();
        $this->setPlugin($plugin);
        $this->setUser($userID);
    }

    public function setPlugin($plugin)
    {
        $this->_plugin = $plugin;
    }

    public function setUser($userID)
    {
        if (empty($userID)) {
            $session = new \csphere\core\session\Session();
            $userID = 1; //$session->get("user_id");

        }
        $this->_userID = $userID;
    }

    public function check($permission)
    {
        $access = false;

        $groups = $this->checkGroups($this->_userID, $permission);
        $user = $this->checkUser($this->_userID, $permission);

        foreach ($groups as $group) {
            if ($group) {
                $access = true;
                break;
            }
        }

        if (!$access && $user) {
            $access = true;
        }

        return $access;
    }

    private function checkGroups($userID, $permission)
    {

        $groups = \csphere\plugins\members\classes\Data::getUserGroups($userID);

        $list = [];

        foreach ($groups as $group) {
            $id = $group['group_id'];
            $name = $group['group_name'];
            $list[$name] = $this->_handler->getValueGroup($this->_plugin, $permission, $id);
        }

        return $list;
    }

    private function checkUser($userID, $permission)
    {
        return false;
    }
}
