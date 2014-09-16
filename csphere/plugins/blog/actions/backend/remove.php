<?php

/**
 * Remove action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Blog
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Blog ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('blog', 'manage');
$bread->add('remove', 'blog/remove/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Remove('blog');

// Delegate action
$rad->delegate();
