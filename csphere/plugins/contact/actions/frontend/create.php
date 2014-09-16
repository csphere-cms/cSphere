<?php

/**
 * Create action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Contact
 * @author    Mathias Milus <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('default');
$bread->add('default', 'default');
$bread->plugin('contact', 'create');
$bread->trace();


 // Get RAD class for this action
$rad = new \csphere\core\rad\Create('contact');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array['contact_date'] = time();

    return $array;
};

$rad->callRecord($record);

// Delegate action
$rad->delegate();
