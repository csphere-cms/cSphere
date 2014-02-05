<?php

/**
 * Return date with time and zone
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Default
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

$data = ['now' => -1];

// Get time zone of user
$zone = \csphere\core\date\Unixtime::userTimeZone();

$data['zone'] = $zone->getName();

// Start view and add content
$view = $loader->load('view');

$view->template('default', 'box_bottombar', $data, true);