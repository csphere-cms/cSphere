<?php

/**
 * Display theme details
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Themes
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
$bread->plugin('themes', 'control');
$bread->add('details', 'themes/details/dir/' . $dir);
$bread->trace();

// Get plugin details if it exists
$meta = new \csphere\core\themes\Metadata();

$exists = $meta->exists($dir);

if ($exists === true) {

    $xml = $loader->load('xml', 'theme');

    $data = $xml->source('theme', $dir);

    $view = $loader->load('view');

    $view->template('themes', 'details', $data);
}