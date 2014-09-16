<?php

/**
 * List action
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

$bread = new \csphere\core\template\Breadcrumb('default');
$bread->add('default', 'default');
$bread->plugin('tags');
$bread->trace();

 // Get RAD class for this action
$rad = new \csphere\core\rad\Listed('tags');

// Define order columns
$order = ['tag_name', 'tag_since'];

$rad->search(['tag_name']);
$rad->delegate('tag_name', $order);
