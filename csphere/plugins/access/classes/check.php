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

    /**
     * Creates an new Check object for the given plugin and user.
     *
     * @param string $plugin the name of the plugin
     * @param int    $userID the id of the user (optional)
     */
    public function __construct($plugin, $userID = 0)
    {
        $this->_handler = new Handler();
        $this->setPlugin($plugin);
        $this->setUser($userID);
    }

    /**
     * sets the name of the plugin
     *
     * @param string $plugin the name of the plugin
     *
     * @return void
     */
    public function setPlugin($plugin)
    {
        $this->_plugin = $plugin;
    }

    /**
     * sets the user id
     *
     * @param int $userID the id of the user
     *
     * @return void
     */
    public function setUser($userID)
    {
        if (empty($userID)) {
            $session = new \csphere\core\session\Session();
            // TODO: still correct or debug rest?
            $userID = 1; //$session->get("user_id");

        }
        $this->_userID = $userID;
    }

    /**
     * Checks whether the current user has the given permission.
     *
     * @param string $permission the permission that should be checked
     *
     * @return bool true if the user has the access.
     */
    public function check($permission)
    {
        $access = false;

        $groups = $this->_checkGroups($this->_userID, $permission);
        $user = $this->_checkUser($this->_userID, $permission);

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

    /**
     * checks whether an user has an specific permission in one of his groups.
     *
     * @param int    $userID     the id of the user
     * @param string $permission the permission that should be checked
     *
     * @return array an array with the name of the group as index and the value for
     * the given permission
     */
    private function _checkGroups($userID, $permission)
    {

        $groups = \csphere\plugins\members\classes\Data::getUserGroups($userID);

        $list = [];

        foreach ($groups as $group) {
            $id = $group['group_id'];
            $name = $group['group_name'];
            $list[$name] = $this->_handler->getValueGroup(
                $this->_plugin, $permission, $id
            );
        }

        return $list;
    }

    /**
     * checks whether an user has an specific permission himself
     *
     * @param int    $userID     the id of the user
     * @param string $permission the permission to check
     *
     * @return bool true if the user has the permission
     */
    private function _checkUser($userID, $permission)
    {
        return false;
    }
}
