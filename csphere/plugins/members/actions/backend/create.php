<?php

/**
 * Create action
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

 // Get RAD class for this action
$rad = new \csphere\core\rad\Create('members');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array = \csphere\plugins\members\classes\Callbacks::record($array);

    $array['member_since'] = time();

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
