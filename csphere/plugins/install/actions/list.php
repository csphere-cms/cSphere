<?php

/**
 * List action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Install
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('install');

$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Get list of required PHP extensions
$xml        = $loader->load('xml', 'plugin');
$default    = $xml->source('plugin', 'default');
$extensions = array();

if (isset($default['required']['extension'])) {

    $extensions = $default['required']['extension'];
}

// Check if these extensions are available
$error = '';
$continue = 'yes';
$missing = '';

foreach ($extensions AS $ext) {

    if (!extension_loaded($ext['value'])) {

        $missing .= $ext['value'] . ' ';
    }
}

if ($missing != '') {

    $error    = $lang['no_php_ext'] . ': ' . $missing;
    $continue = '';
}

$data = array('error' => $error, 'continue' => $continue);

// Send data to view
$view = $loader->load('view');

$view->template('install', 'list', $data);