<?php

/**
 * Options action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Sites
 * @author    Daniel Burke and thanks to Martin Ederer <contact@csphere.eu>
 * @copyright 2014 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('sites', 'manage');
$bread->add('options');
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Options('sites');

// Delegate action
$rad->delegate();
