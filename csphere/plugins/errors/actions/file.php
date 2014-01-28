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
$path = \csphere\core\init\path() . 'csphere/storage/logs/errors/';

$date = \csphere\core\http\Input::get('get', 'date');

$replace = array('.', '/', '\\');
$date    = str_replace($replace, '', $date);
$name    = $date . '.log';

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('errors', 'control');
$bread->add('file', 'errors/file/date/' . $date);
$bread->trace();

if (file_exists($path . $name)) {

    // Get contents of error log file and format them
    $content = file_get_contents($path . $name);
    $entries = explode("--------\n", $content);
    $amount  = count($entries) - 1;

    $data = array('date' => $date, 'count' => $amount, 'entries' => array());

    // Each error entry should be an array element
    for ($i = 1; $i <= $amount; $i++) {

        $first   = explode("\n", $entries[$i], 2);
        $time    = $first[0];
        $second  = explode("\n", $first[1], 2);
        $message = ltrim(substr($second[0], 8));

        $data['entries'][] = array('message' => $message,
                                   'time'    => $time,
                                   'entry'   => $i);
    }

    // Newest entry on top
    krsort($data['entries']);

    // Send data to view
    $view = $loader->load('view');

    $view->template('errors', 'file', $data);
}