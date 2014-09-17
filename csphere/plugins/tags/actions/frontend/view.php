<?php

/**
 * View action
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

// tags ID
$id = \csphere\core\http\Input::get('get', 'id');

$bread = new \csphere\core\template\Breadcrumb('default');
$bread->add('default', 'default');
$bread->plugin('tags', 'list');
$bread->add('view', 'tags/view/id/' . $id);
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\View('tags');

// Delegate action
$rad->delegate();
