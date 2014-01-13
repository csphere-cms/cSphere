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
$bread = new \csphere\core\template\Breadcrumb('languages');

$bread->add('control');
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

// Only proceed if target was found and translation exists
if ($exists === true AND $dir_exists === true) {

    $error = '';
    $xml   = $loader->load('xml', 'language');
    $data  = $xml->source($type, $dir, $short);

    // Compare definitions with the one in default plugin
    $default  = $xml->source('plugin', 'default');
    $def_lang = array();
    $cur_lang = array();

    foreach ($default['definitions'] AS $def) {

        $def_lang[$def['name']] = $def['value'];
    }

    foreach ($data['definitions'] AS $def) {

        $cur_lang[$def['name']] = $def['value'];
    }

    $test = array_diff_key($cur_lang, $def_lang);
    $bad  = array_diff_key($cur_lang, $test);

    foreach ($bad AS $key => $name) {

        $error .= $lang['warn_override'] . ': ' . $key . "\n";
    }

    // Compare this language information with another main language
    $use_lang = $short == 'en' ? 'de' : 'en';
    $alt_lang = $xml->source($type, $dir, $use_lang);
    $top_lang = array();

    foreach ($alt_lang['definitions'] AS $def) {

        $top_lang[$def['name']] = $def['value'];
    }

    $test = array_diff_key($cur_lang, $top_lang);

    foreach ($test AS $key => $name) {

        $error .= $lang['warn_difference'] . ': ' . $key . "\n";
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