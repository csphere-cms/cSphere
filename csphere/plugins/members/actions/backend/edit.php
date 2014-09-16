<?php

/**
 * Edit action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Members
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Members ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('members', 'manage');
$bread->add('edit', 'members/edit/id/' . $id);
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\Edit('members');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array = \csphere\plugins\members\classes\Callbacks::record($array);

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) {

    $array = \csphere\plugins\members\classes\Callbacks::data($array);

    return $array;
};

$rad->callData($data);

// Delegate action
$rad->delegate();
