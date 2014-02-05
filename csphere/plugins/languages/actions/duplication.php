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
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('languages', 'control');
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
    $match   = [];

    // Prepare data of default plugin
    $default = $xml->source('plugin', 'default', $short, true);
    $default = isset($default['definitions']) ? $default['definitions'] : [];
    $def     = [];

    foreach ($default AS $part) {

        $def[$part['name']] = $part['value'];
    }

    // Get entries already translated by default plugin
    foreach ($plugins AS $plugin) {

        // Skip default plugin
        if ($plugin['short'] != 'default') {

            // Check if plugin translation is missing
            $source = $xml->source('plugin', $plugin['short'], $short, true);
            $source = isset($source['definitions']) ? $source['definitions'] : [];

            // Add matches to array if it is not the plugin name
            foreach ($source AS $part) {

                $key = $part['name'];

                if (isset($def[$key]) && $key != $plugin['short']) {

                    $match[$key][] = $plugin['short'];

                }
            }
        }
    }

    ksort($match);

    // Format data
    $dup = [];

    foreach ($match AS $key => $plugins) {

        $names = implode(', ', $plugins);
        $dup[] = ['key' => $key, 'plugins' => $names];
    }

    // Create link for every plugin
    $data = ['short' => $short, 'duplicate' => $dup, 'error' => $error];

    // Output results
    $view = $loader->load('view');

    $view->template('languages', 'duplication', $data);
}