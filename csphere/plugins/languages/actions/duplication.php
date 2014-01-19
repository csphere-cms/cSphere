<?php

/**
 * Duplicated language entries across all plugins
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Languages
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

$short = \csphere\core\http\Input::get('get', 'short');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('languages');

$bread->add('control');
$bread->add('plugins', 'languages/plugins/short/' . $short);
$bread->add('duplication', 'languages/duplication/short/' . $short);
$bread->trace();

// Check if translation exists
$meta = new \csphere\core\translation\Metadata();

$exists = $meta->exists($short);

if ($exists === true) {

    $error   = '';
    $plugins = $meta->plugins($short);
    $xml     = $loader->load('xml', 'language');
    $match   = array();

    // Get duplicated entries out of plugins
    foreach ($plugins AS $plugin) {

        // Check if plugin translation is missing
        $source = $xml->source('plugin', $plugin['short'], $short, true);
        $source = isset($source['definitions']) ? $source['definitions'] : array();

        // Add definitions to super array
        foreach ($source AS $part) {

            $key = $part['name'];

            if (isset($match[$key])) {

                $match[$key] = array_merge($match[$key], array($plugin['short']));

            } else {

                $match[$key] = array($plugin['short']);
            }
        }
    }

    ksort($match);

    // Kick out every key that only appeared once and format data
    $dup = array();

    foreach ($match AS $key => $plugins) {

        $count = count($plugins);

        if ($count > 1) {

            $names = implode(', ', $plugins);
            $dup[] = array('key' => $key, 'plugins' => $names);
        }
    }

    // Create link for every plugin
    $data = array('short' => $short, 'duplicate' => $dup, 'error' => $error);

    // Output results
    $view = $loader->load('view');

    $view->template('languages', 'duplication', $data);
}