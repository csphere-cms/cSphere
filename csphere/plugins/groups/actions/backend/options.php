<?php

/**
 * Options action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Groups
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('groups', 'manage');
$bread->add('options');
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\Options('groups');

// Define closure to execute before record is send to database
$record = function ($array) {

    $group_id = '';

    if (!empty($array['main_name'])) {
        $dm_groups  = new \csphere\core\datamapper\Model('groups');
        $group      = $dm_groups->read($array['main_name'], 'group_name');
        $group_id = empty($group['group_id']) ? '' : $group['group_id'];
    }

    $array['main_id'] = $group_id;
    unset($array['main_name']);

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) {

    $group_name = '';

    if (!empty($array['main_id'])) {
        $dm_groups  = new \csphere\core\datamapper\Model('groups');
        $group      = $dm_groups->read($array['main_id']);
        $group_name = empty($group['group_name']) ? '' : $group['group_name'];
    }

    $array['main_name'] = $group_name;

    return $array;
};

$rad->callData($data);

// Delegate action
$rad->delegate();
