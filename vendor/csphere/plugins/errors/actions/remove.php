<?php

/**
 * Error file details
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Errors
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Check for error log file
$path = \csphere\core\init\path() . 'csphere/logs/errors/';

$date = \csphere\core\http\Input::get('get', 'date');

$replace = array('.', '/', '\\');
$date    = str_replace($replace, '', $date);
$name    = $date . '.log';

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('errors');

$bread->add('control');
$bread->add('remove', 'errors/remove/date/' . $date);
$bread->trace();

if (file_exists($path . $name)) {

    unlink($path . $name);
}

$previous = \csphere\core\url\Link::href('errors', 'control');

$data = array('previous' => $previous, 'type' => 'green');

$data['plugin_name'] = \csphere\core\translation\Fetch::key('errors', 'errors');
$data['action_name'] = \csphere\core\translation\Fetch::key('errors', 'remove');
$data['message']     = \csphere\core\translation\Fetch::key('errors', 'remove_ok');

// Send data to view
$view = $loader->load('view');

$view->template('default', 'message', $data);