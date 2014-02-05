<?php

/**
 * List of plugins that provide plugins management
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Languages
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('languages', 'control');
$bread->trace();

// Get plugin metadata
$meta = new \csphere\core\translation\Metadata();

$languages = $meta->details();

// Create link for every theme
$data = ['languages' => $languages];

// Output results
$view = $loader->load('view');

$view->template('languages', 'control', $data);