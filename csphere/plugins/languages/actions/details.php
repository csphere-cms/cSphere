<?php

/**
 * Display theme details
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
$dir   = \csphere\core\http\Input::get('get', 'dir');
$theme = \csphere\core\http\Input::get('get', 'theme');
$type  = empty($theme) ? 'plugin' : 'theme';
$typed = $type . 's';

$lang = \csphere\core\translation\Fetch::keys('languages');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('languages', 'control');
$bread->add($typed, 'languages/' . $typed . '/short/' . $short);

$details = 'languages/details/short/' . $short . '/dir/' . $dir;

if ($type == 'theme') {

    $details .= '/theme/1';
}

$bread->add('details', $details);
$bread->trace();

// Check for target and translation details
$meta = new \csphere\core\translation\Metadata();

$exists = $meta->exists($short);

if ($type == 'plugin') {

    $target = new \csphere\core\plugins\Metadata();

} else {

    $target = new \csphere\core\themes\Metadata();
}

$dir_exists = $target->exists($dir);
$src_exists = false;
$xml        = null;
$error      = '';
$data       = [];
$cur_lang   = [];

// Only proceed if target was found and translation exists
if ($exists === true && $dir_exists === true) {

    $xml   = $loader->load('xml', 'language');
    $data  = $xml->source($type, $dir, $short, true);

    if ($data != []) {

        // This is the one and only valid case
        $src_exists = true;
    }
}

// Only proceed if source file could be found
if ($src_exists === true) {

    foreach ($data['definitions'] AS $def) {

        $cur_lang[$def['name']] = $def['value'];
    }

    // Check if plugin name is set at all
    if (!isset($cur_lang[$dir])) {

        $error .= $lang['warn_noname'] . ': ' . $dir . "\n";
    }

    // Compare definitions with the one in default plugin
    if ($type == 'theme' || $dir != 'default') {

        $default  = $xml->source('plugin', 'default');
        $def_lang = [];

        foreach ($default['definitions'] AS $def) {

            $def_lang[$def['name']] = $def['value'];
        }

        $test = array_diff_key($cur_lang, $def_lang);
        $test = array_diff_key($cur_lang, $test);

    } else {

        $test = [];
    }

    // Remove plugin name since that setting is required
    unset($test[$dir]);

    if ($test != []) {

        $test   = array_keys($test);
        $error .= $lang['warn_override'] . ': ' . implode(' ', $test) . "\n";
    }

    // Compare this language information with another main language
    $use_lang = $short != 'en' ? 'en' : 'de';
    $alt_lang = $xml->source($type, $dir, $use_lang);
    $top_lang = [];

    foreach ($alt_lang['definitions'] AS $def) {

        $top_lang[$def['name']] = $def['value'];
    }

    $test = array_diff_key($cur_lang, $top_lang);

    if ($test != []) {

        $test   = array_keys($test);
        $error .= $lang['warn_difference'] . ': ' . implode(' ', $test) . "\n";
    }

    // Get undefined keys
    $test = array_diff_key($top_lang, $cur_lang);

    if ($test != []) {

        $test   = array_keys($test);
        $error .= $lang['warn_missing'] . ': ' . implode(' ', $test) . "\n";
    }

    // Define vars for template
    $data['error'] = $error;
    $data['short'] = $short;
    $data['dir']   = $dir;
    $data['type']  = $type;

    // Output results
    $view = $loader->load('view');

    $view->template('languages', 'details', $data);
}