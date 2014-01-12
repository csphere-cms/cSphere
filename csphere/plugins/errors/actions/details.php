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
$path       = \csphere\core\init\path();
$path_error =  $path . 'csphere/storage/logs/errors/';

$date  = \csphere\core\http\Input::get('get', 'date');
$entry = (int)\csphere\core\http\Input::get('get', 'entry');

$replace = array('.', '/', '\\');
$date    = str_replace($replace, '', $date);
$name    = $date . '.log';

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('errors');

$bread->add('control');
$bread->add('file', 'errors/file/date/' . $date);
$bread->add('entry', 'errors/file/date/' . $date . '/entry/' . $entry);
$bread->trace();

// List of special chars in error logs
$special = array('{' => 0, '[' => 1);

if (file_exists($path_error . $name)) {

    // Get contents of error log file and format them
    $file = file_get_contents($path_error . $name);

    $content = file_get_contents($path_error . $name);
    $entries = explode("--------\n", $content);

    $backtrace = isset($entries[$entry]) ? $entries[$entry] : '';

    $data = array('date' => $date, 'entry' => $entry, 'trace' => array());

    // Get information out of string parts
    $parts = explode("\n", $backtrace);

    // Set start and end of trace
    $end   = count($parts) - 1;
    $start = 6;

    for ($i = 5; $i < $end; $i++) {

        if ($parts[$i] == 'Trace:') {

            $start = $i;
        }
    }

    // Time, Message, Code, File and Line are before Trace
    $error = array('time' => $parts[0]);

    $error['message'] = ltrim(substr($parts[1], 8));
    $error['code']    = ltrim(substr($parts[$start - 3], 5));
    $error['file']    = ltrim(substr($parts[$start - 2], 5));
    $error['line']    = ltrim(substr($parts[$start - 1], 5));
    $data['error']    = $error;

    // Format trace
    for ($i = $start; $i < $end; $i++) {

        // Split trace part into usable parts
        $step   = $i - $start - 1;
        $string = explode(' ', $parts[$i], 3);

        if (isset($string[1]) AND isset($special[$string[1][0]])) {

            // Special case for curly braces
            $nostep          = explode(' ', $parts[$i], 2)[1];
            $split           = explode(':', $nostep, 2);
            $call            = isset($split[1]) ? $split[1] : '';
            $data['trace'][] = array('step' => $step,
                                     'file' => $split[0],
                                     'line' => '',
                                     'call' => $call);

        } elseif (isset($string[1])) {

            // This is the default case
            $trace = array('step' => $step);

            $file = explode('(', $string[1]);
            $line = isset($file[1]) ? explode(')', $file[1]) : array();

            // Shorten file names
            if (isset($file[0])) {

                $file = str_replace('\\', '/', $file[0]);
                $file = str_replace($path, '', $file);

            } else {

                $file = '';
            }

            // Set backtrace details
            $trace['file']   = $file;
            $trace['line']   = isset($line[0]) ? $line[0] : '';
            $trace['call']   = isset($string[2]) ? $string[2] : '';
            $data['trace'][] = $trace;
        }
    }

    // Send data to view
    $view = $loader->load('view');

    $view->template('errors', 'details', $data);
}