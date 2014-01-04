<?php

/**
 * List action
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
$rad = new \csphere\core\rad\Listed('groups');

$rad->map('manage', 'manage');

// Define order columns
$order = array('group_name', 'group_since');

$rad->search(array('group_name'), true, true);
$rad->delegate('group_name', $order);