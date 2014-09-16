<?php

/**
 * View action
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

// Policies ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('default');
$bread->add('default', 'default');
$bread->plugin('policies');
$bread->add('view', 'policies/view/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\View('policies');

// Delegate action
$rad->delegate();
