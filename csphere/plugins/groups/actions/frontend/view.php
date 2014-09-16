<?php

/**
 * View action
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

// Groups ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('default');
$bread->add('default', 'default');
$bread->plugin('groups');
$bread->add('view', 'groups/view/id/' . $id);
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\View('groups');

// Delegate action
$rad->delegate();
