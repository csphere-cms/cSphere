<?php

/**
 * Display access details
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Access
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$check = new \csphere\plugins\access\classes\Check("access");

$loader = \csphere\core\service\Locator::get();

$dir = \csphere\core\http\Input::get('get', 'dir');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('access', 'control');
$bread->add('details', 'access/details/dir/' . $dir);
$bread->trace();

//@ToDo: Ensure Plugin is existent.
$data['plugin']['name'] = htmlspecialchars($_GET['name']);

$handler = new \csphere\plugins\access\classes\Handler();

if (!empty($_POST)) {
    if ($check->checkAccess("groupedit")) {
        $handler->updatePlugin($data['plugin']['name']);
    } else {
        die("Sorry, you are not allowed to edit Group Permissions.");
    }
}

$data['permissions'] = $handler->loadPermissions($data['plugin']['name']);

$groupFinder = new \csphere\core\datamapper\Finder("groups");
$data['groups'] = $groupFinder->find(0, $groupFinder->count());

$translation = \csphere\core\translation\Fetch::keys($data['plugin']['name']);

foreach ($data['groups'] as &$group) {
    $group['permissions'] = $data['permissions'];
    foreach ($group['permissions'] as $key => &$perm) {
        $perm['permission_title'] = $key;
        $perm['permission_label'] = $translation['permission_' . $key];
        $perm['permission_value'] = $handler->getValueGroup($data['plugin']['name'], $key, $group['group_id']);
    }

}

$view = $loader->load('view');
$view->template('access', 'details', $data);

