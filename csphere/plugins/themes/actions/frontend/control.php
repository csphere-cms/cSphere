<?php

/**
 * List of plugins that provide plugins management
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Themes
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('themes', 'control');
$bread->trace();

// Get plugin metadata
$meta = new \csphere\core\themes\Metadata();

$themes = $meta->details();

// Create link for every theme
$data = ['themes' => $themes];

// Output results
$view = $loader->load('view');

$view->template('themes', 'control', $data);
