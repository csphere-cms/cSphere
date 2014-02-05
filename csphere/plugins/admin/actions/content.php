<?php

/**
 * List of plugins that provide content management
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Admin
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');

$bread->add('content');
$bread->trace();

// Get plugin metadata
$meta = new \csphere\core\plugins\Metadata();

$plugins = $meta->entries('admin', 'content');

// Create link for every plugin
$data = ['action' => 'manage', 'plugins' => $plugins];

// Output results
$view = $loader->load('view');

$view->template('admin', 'content', $data);