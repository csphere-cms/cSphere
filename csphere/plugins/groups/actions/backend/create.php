<?php

/**
 * Create action
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

// Get RAD class for this action
$rad = new \csphere\core\rad\Create('groups');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array['group_since'] = time();

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) {

    $access = new \csphere\plugins\access\classes\Handler();
    $access->initiateGroup($array['group_id']);

    return $array;
};

$rad->callAfterRecord($data);

// Delegate action
$rad->delegate();
