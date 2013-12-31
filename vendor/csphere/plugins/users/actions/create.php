<?php

/**
 * Create action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

 // Get RAD class for this action
$rad = new \csphere\core\rad\Create('users');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array['user_since']  = time();
    $array['user_laston'] = $array['user_since'];

    $pwd = \csphere\core\authentication\Password::hash($array['user_password']);

    $array['user_password'] = $pwd;

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) {

    unset($array['user_password']);

    return $array;
};

$rad->callData($data);

// Delegate action
$rad->delegate();