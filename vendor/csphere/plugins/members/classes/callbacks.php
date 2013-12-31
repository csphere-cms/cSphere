<?php

/**
 * Callbacks for members plugin
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Members
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\members\classes;

/**
 * Callbacks for members plugin
 *
 * @category  Plugins
 * @package   Members
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Callbacks
{
    /**
     * Add group and user name to data
     *
     * @param array $array Array with data for template
     *
     * @return array
     **/

    public static function data(array $array)
    {
        // User table
        $user_name = '';

        if (!empty($array['user_id'])) {

            $dm_users  = new \csphere\core\datamapper\Model('users');
            $user      = $dm_users->read($array['user_id']);
            $user_name = empty($user['user_name']) ? '' : $user['user_name'];
        }

        $array['user_name'] = $user_name;

        // Group table
        $group_name = '';

        if (!empty($array['group_id'])) {
            $dm_groups  = new \csphere\core\datamapper\Model('groups');
            $group      = $dm_groups->read($array['group_id']);
            $group_name = empty($group['group_name']) ? '' : $group['group_name'];
        }

        $array['group_name'] = $group_name;

        return $array;
    }

    /**
     * Add group and user serial to record
     *
     * @param array $array Array with data of record
     *
     * @return array
     **/

    public static function record(array $array)
    {
        // User table
        $user_id = '';

        if (!empty($array['user_name'])) {

            $dm_users  = new \csphere\core\datamapper\Model('users');
            $user      = $dm_users->read($array['user_name'], 'user_name');
            $user_id = empty($user['user_id']) ? '' : $user['user_id'];
        }

        $array['user_id'] = $user_id;
        unset($array['user_name']);

        // Group table
        $group_id = '';

        if (!empty($array['group_name'])) {
            $dm_groups  = new \csphere\core\datamapper\Model('groups');
            $group      = $dm_groups->read($array['group_name'], 'group_name');
            $group_id = empty($group['group_id']) ? '' : $group['group_id'];
        }

        $array['group_id'] = $group_id;
        unset($array['group_name']);

        return $array;
    }
}