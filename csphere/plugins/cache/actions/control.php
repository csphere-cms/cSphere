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
$bread = new \csphere\core\template\Breadcrumb('cache');

$bread->add('control');
$bread->trace();

// Get cache keys
$cache  = $loader->load('cache');
$driver = $cache->driver();
$info   = $cache->info();
$count  = count($info);

$entries = array();

foreach ($info AS $entry) {

    if (empty($entry['size'])) {

        $entry['size'] = '-';

    } else {

        $entry['size'] = \csphere\core\files\File::size($entry['size']);
    }

    $entries[] = $entry;
}

$data = array('count' => $count, 'driver' => $driver, 'entries' => $entries);

// Send data to view
$view = $loader->load('view');

$view->template('cache', 'control', $data);