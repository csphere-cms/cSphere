<?php

/**
 * Server software information
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Environment
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('environment');

$bread->add('control');
$bread->trace();

// Collect server information
$data = array();

$data['operating_system'] = php_uname('s') . ' ' . php_uname('r');
$data['hostname']         = php_uname('n');
$data['php_handler']      = php_sapi_name();
$data['php_version']      = phpversion();
$data['webserver']        = '';

if (function_exists('apache_get_version')) {

    $data['webserver'] = apache_get_version();

} elseif (isset($_SERVER['SERVER_SOFTWARE'])) {

    $data['webserver'] = str_replace('/', ' ', $_SERVER['SERVER_SOFTWARE']);
}

// Output results
$view = $loader->load('view');

$view->template('environment', 'control', $data);