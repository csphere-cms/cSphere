<?php

/**
 * Remove action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Sites
 * @author    Daniel Burke and thanks to Martin Ederer <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Sites ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('sites', 'manage');
$bread->add('remove', 'sites/remove/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Remove('sites');

// Delegate action
$rad->delegate();
