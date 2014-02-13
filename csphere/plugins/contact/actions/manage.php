<?php

/**
 * List action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Contact
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

 // Get RAD class for this action
$rad = new \csphere\core\rad\Listed('contact');

$rad->map('manage', 'manage');

// Define order columns
$order = array('contact_date', 'contact_name', 'contact_subject');

$rad->search(array('contact_name'), true);
$rad->delegate('contact_date', $order);