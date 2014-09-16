<?php

/**
 * Edit action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Policies
 * @author    Daniel Burke <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Policies ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('policies', 'manage');
$bread->add('edit', 'policies/edit/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Edit('policies');

// Define closure to execute before record is send to database
$record = function ($data) {

    $data['policie_date'] = time();

    return $data;
};

$rad->callRecord($record);

// Delegate action
$rad->delegate();
