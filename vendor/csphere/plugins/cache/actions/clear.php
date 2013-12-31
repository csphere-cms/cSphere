<?php

/**
 * Clears the cache
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
$bread = new \csphere\core\template\Breadcrumb('cache');

$bread->add('control');
$bread->add('clear');
$bread->trace();

// Clear cache
$cache  = $loader->load('cache');
$driver = $cache->clear();

$previous = \csphere\core\url\Link::href('cache', 'control');

$data = array('previous' => $previous, 'type' => 'green');

$data['plugin_name'] = \csphere\core\translation\Fetch::key('cache', 'cache');
$data['action_name'] = \csphere\core\translation\Fetch::key('cache', 'clear');
$data['message']     = \csphere\core\translation\Fetch::key('cache', 'clear_ok');

// Send data to view
$view = $loader->load('view');

$view->template('default', 'message', $data);