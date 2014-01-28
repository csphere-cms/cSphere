<?php

/**
 * Display database details of a plugin
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

$dir = \csphere\core\http\Input::get('get', 'dir');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('database', 'control');
$bread->add('tables');
$bread->add('details', 'database/details/dir/' . $dir);
$bread->trace();

// Get plugin database details if it exists
$meta = new \csphere\core\plugins\Database($dir);

$exists = $meta->exists();

if ($exists === true) {

    $xml = $loader->load('xml', 'database');

    $data = $xml->source('plugin', $dir);

    $data['dir'] = $dir;

    $view = $loader->load('view');

    $view->template('database', 'details', $data);
}