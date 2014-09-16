<?php

/**
 * Create action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Tags
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('tags', 'manage');
$bread->add('create');
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\Create('tags');

// Define closure to execute before record is send to database
$record = function ($array) {

    $array['tag_since'] = time();

    return $array;
};

$rad->callRecord($record);

// Delegate action
$rad->delegate();
