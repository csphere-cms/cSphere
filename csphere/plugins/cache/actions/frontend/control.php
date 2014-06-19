<?php

/**
 * Cache server and client information
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('cache', 'control');
$bread->trace();

// Collect server information
$cache = $loader->load('cache');
$data  = $cache->info();

// Output results
$view = $loader->load('view');

$view->template('cache', 'control', $data);
