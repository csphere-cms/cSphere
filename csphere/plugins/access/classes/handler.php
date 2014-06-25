<?php

/**
 * Handler Class for Access Module
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
 * Handler Class for Access Module
 *
 * @category  Plugins
 * @package   Access
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Handler
{

    /**
     * @param $plugin
     * @param $permission
     * @param $group
     * @return mixed
     */
    public function getValueGroup($plugin, $permission, $group)
    {
        $table = new \csphere\core\datamapper\Finder("access", "group");
        $table->where("access_group_permission", "=", $plugin . "." . $permission);
        $table->where("group_id", "=", $group);
        $res = $table->first();

        return $res['access_group_value'];
    }

    /**
     * @param $permission
     * @param $userID
     */
    public function getValueUser($permission, $userID)
    {

    }

    /**
     * @param $plugin
     */
    public function updatePlugin($plugin)
    {
        $groupFinder = new \csphere\core\datamapper\Finder("groups");
        $groups = $groupFinder->find(0, $groupFinder->count());

        foreach ($groups as $group) {
            $id = $group['group_id'];;
            $name = $group['group_name'];
            if (!empty($_POST[$name])) {
                foreach ($_POST[$name] as $permission => $value) {
                    $this->_setValueGroup($plugin, $permission, $value, $id);
                }
            }
        }
    }


    /**
     * @param $plugin
     * @param $permission
     * @param $value
     * @param $groupID
     * @return bool
     */

    private function _setValueGroup($plugin, $permission, $value, $groupID)
    {
        $table = new \csphere\core\datamapper\Finder("access", "group");
        $table->columns("access_group_id");
        $table->where("access_group_permission", "=", $plugin . "." . $permission);
        $table->where("group_id", "=", $groupID);
        $res = $table->first();

        if (!empty($res)) {

            $data['access_group_id'] = $res['access_group_id'];
            $data['group_id'] = $groupID;
            $data['access_group_permission'] = $plugin . "." . $permission;
            $data['access_group_value'] = intval($value);

            $model = new \csphere\core\datamapper\Model("access", "group");
            $model->update($data);

            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @param $permission
     * @param $userID
     */
    public function _setValueUser($permission, $userID)
    {

    }

    /**
     * @param $plugin
     * @param array $groups
     */
    public function initiateDefault($plugin, $groups = [])
    {

        if ($permissions = $this->loadPermissions($plugin)) {

            $finder = new \csphere\core\datamapper\Finder("access", "group");
            $model = new \csphere\core\datamapper\Model("access", "group");


            if (empty($groups)) {
                $groupFinder = new \csphere\core\datamapper\Finder("groups");
                $tmpGroups = $groupFinder->find(0, $groupFinder->count());

                foreach ($tmpGroups as $tmpGroup) {
                    $groups[] = $tmpGroup['group_id'];
                }
            }

            foreach ($permissions as $permission => $permissionInfo) {
                $databasePerm = $plugin . "." . $permission;
                $finder->where("access_group_permission", "=", $databasePerm);
                $finder->remove();

                $data['access_group_permission'] = $databasePerm;
                $data['access_group_value'] = 0;

                foreach ($groups as $group) {
                    $data['group_id'] = $group;
                    $model->insert($data);
                }
            }
        }

    }

    /**
     * @param $groupID
     */
    public function initiateGroup($groupID)
    {
        // Get plugin metadata
        $meta = new \csphere\core\plugins\Metadata();

        $plugins = $meta->details();
        foreach ($plugins as $plugin) {
            $this->initiateDefault($plugin['short'], [$groupID]);
        }
    }

    public function loadPermissions($plugin)
    {

        $loader = \csphere\core\service\Locator::get();
        // Check for database XML file
        $path = \csphere\core\init\path();
        $file = $path . 'csphere/plugins/' . $plugin . '/access.xml';

        if (file_exists($file)) {

            // Get access content of plugin
            $xml = $loader->load('xml', 'access');
            $permissions = $xml->source('plugin', $plugin);

        } else {
            $permissions = [];
        }

        return $permissions;
    }
}
