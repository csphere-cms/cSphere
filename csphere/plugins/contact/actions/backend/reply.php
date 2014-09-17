<?php
/**
 * Reply action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Contact
 * @author    Patrick Jaskulski <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Get RAD class for this action
$rad = new \csphere\core\rad\Edit('contact');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array['contact_reply_date'] = time();

    return $array;
};

$rad->callRecord($record);

// Delegate action
$rad->delegate();
