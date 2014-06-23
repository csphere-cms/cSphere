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

$loader = \csphere\core\service\Locator::get();

$dir = \csphere\core\http\Input::get('get', 'dir');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('access', 'control');
$bread->add('details', 'access/details/dir/' . $dir);
$bread->trace();

$view = $loader->load('view');

$groupFinder = new \csphere\core\datamapper\Finder("groups");

$data['plugin']['name']=htmlspecialchars($_GET['name']);
$data['groups'] = $groupFinder->find(0, $groupFinder->count());

$view->template('access', 'details', $data);

