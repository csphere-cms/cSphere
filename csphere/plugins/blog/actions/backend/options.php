<?php

/**
 * Options action
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

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('blog', 'manage');
$bread->add('options');
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Options('blog');

// Delegate action
$rad->delegate();
