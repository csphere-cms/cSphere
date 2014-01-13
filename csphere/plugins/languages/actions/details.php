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

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('languages');

$bread->add('control');
$bread->add($typed, 'languages/' . $type . '/short/' . $short);

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

    $xml = $loader->load('xml', 'language');

    $data = $xml->source($type, $dir, $short);

    $data['short'] = $short;
    $data['dir']   = $dir;
    $data['type']  = $type;

    $view = $loader->load('view');

    $view->template('languages', 'details', $data);
}