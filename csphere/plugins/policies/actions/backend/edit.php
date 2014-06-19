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
