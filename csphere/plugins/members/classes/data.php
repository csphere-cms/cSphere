<?php

/**
 * Data for members plugin
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Members
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\members\classes;

/**
 * Data for members plugin
 *
 * @category  Plugins
 * @package   Members
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Data
{
    /**
     * Get all user groups the user is member of.
     *
     * @param int $userID the ID of a user
     *
     * @return array an array
     */
    public static function getUserGroups($userID)
    {

        $table = new \csphere\core\datamapper\Finder("members");

        $table->where("user_id", "=", $userID);
        $table->join("groups", "", "group_id");
        return $table->find(0, 0);
    }
}
