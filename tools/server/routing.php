<?php

/**
 * Routes all incoming requests for the builtin webserver
 *
 * PHP Version 5
 *
 * @category  Tools
 * @package   Server
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Check if a real file is requested
$uri    = str_replace('..', '', $_SERVER['REQUEST_URI']);
$uri    = explode('?', $uri, 2);
$target = $_SERVER['DOCUMENT_ROOT'] . $uri[0];

// Hide open_basedir restrictions and other problems
if (@file_exists($target)) {

    // This tells the builtin webserver to serve the target file
    return false;

} else {

    // Warning: Some browsers try to open /favicon.ico for no reason
    include '../../index.php';
}
