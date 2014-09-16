<?php

/**
 * Remove action
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

// Tags ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('tags', 'manage');
$bread->add('remove', 'tags/remove/id/' . $id);
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\Remove('tags');

// Delegate action
$rad->delegate();
