<?php

/**
 * List of cache entries
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
$bread->add('keys');
$bread->trace();

// Get cache keys
$cache  = $loader->load('cache');
$keys   = $cache->keys();
$count  = count($keys);

$entries = array();

foreach ($keys AS $entry) {

    // Check size since not all drivers may support that feature
    if (empty($entry['size'])) {

        $entry['size'] = '-';

    } else {

        $entry['size'] = \csphere\core\files\File::size($entry['size']);
    }

    $entries[] = $entry;
}

$data = array('count' => $count, 'entries' => $entries);

// Send data to view
$view = $loader->load('view');

$view->template('cache', 'keys', $data);