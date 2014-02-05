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

// Get language data
$lang = \csphere\core\translation\Fetch::keys('errors');

// Check for error log file
$path = \csphere\core\init\path() . 'csphere/storage/logs/errors/';

$date = \csphere\core\http\Input::get('get', 'date');

$replace = ['.', '/', '\\'];
$date    = str_replace($replace, '', $date);
$name    = $date . '.log';

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('errors', 'control');
$bread->add('remove', 'errors/remove/date/' . $date);
$bread->trace();

if (file_exists($path . $name)) {

    unlink($path . $name);
}

$previous = \csphere\core\url\Link::href('errors', 'control');

$data = ['previous' => $previous, 'type' => 'green'];

$data['plugin_name'] = $lang['errors'];
$data['action_name'] = \csphere\core\translation\Fetch::key('default', 'remove');
$data['message']     = $lang['remove_ok'];

// Send data to view
$view = $loader->load('view');

$view->template('default', 'message', $data);