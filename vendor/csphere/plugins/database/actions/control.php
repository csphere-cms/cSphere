<?php

/**
 * Database server and client information
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

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('database');

$bread->add('control');
$bread->trace();

// Collect server information
$database       = $loader->load('database');
$data           = $database->info();
$data['driver'] = $database->driver();

// Format size if it is an iteger
if (is_integer($data['size'])) {

    $data['size'] = \csphere\core\files\File::size($data['size']);
}

// Shorten client version
$data['client'] = explode('$Id', $data['client'])[0];

// Output results
$view = $loader->load('view');

$view->template('database', 'control', $data);