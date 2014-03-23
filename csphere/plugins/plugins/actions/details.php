<?php

/**
 * Display plugin details
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Plugins
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
$bread->plugin('plugins', 'control');
$bread->add('details', 'plugins/details/dir/' . $dir);
$bread->trace();

// Get plugin details if it exists
$meta = new \csphere\core\plugins\Metadata();

$exists = $meta->exists($dir);

if ($exists === true) {

    $xml = $loader->load('xml', 'plugin');

    $data = $xml->source('plugin', $dir);

    $view = $loader->load('view');

    $view->template('plugins', 'details', $data);
}
