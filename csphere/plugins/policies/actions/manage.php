<?php

/**
 * List action
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
$rad = new \csphere\core\rad\Listed('policies');

$rad->map('manage', 'manage');

// Define order columns
$order = ['policie_date'];

$rad->delegate('policie_date DESC', $order);
