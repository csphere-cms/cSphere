<?php

/**
 * Edit action
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

// Users ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('users', 'manage');
$bread->add('edit', 'users/edit/id/' . $id);
$bread->trace();


 // Get RAD class for this action
$rad = new \csphere\core\rad\Edit('users');

// Define closure to execute before record is send to database
$record = function ($array) {

    unset($array['user_password']);

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
