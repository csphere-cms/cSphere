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

// Get language data
$lang = \csphere\core\translation\Fetch::keys('cache');

// Clear OPcache
if (function_exists('opcache_reset')) {

    opcache_reset();
}

// Clear cache
$cache = $loader->load('cache');
$cache->clear();

$previous = \csphere\core\url\Link::href('cache', 'control');

$data = array('previous' => $previous, 'type' => 'green');

$data['plugin_name'] = $lang['cache'];
$data['action_name'] = $lang['clear'];
$data['message']     = $lang['clear_ok'];

// Send data to view
$view = $loader->load('view');

$view->template('default', 'message', $data);