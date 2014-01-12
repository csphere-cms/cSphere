<?php

/**
 * Processes all incoming requests
 *
 * PHP Version 5
 *
 * @category  Index
 * @package   Index
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Check for PHP version requirement
$php = '5.4.0';

$check = version_compare(PHP_VERSION, $php, '>=');

if ($check === true) {

    // Start execution
    set_include_path(__DIR__);

    include 'csphere/core/init/functions.php';
    \csphere\core\init\start();

} else {

    // Use echo to show this message even with display_errors off
    echo 'PHP ' . $php . ' or newer required but found ' . PHP_VERSION;
}