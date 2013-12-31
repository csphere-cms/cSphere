<?php

/**
 * List of plugins that provide system settings
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

$bread->add('system');
$bread->trace();

// Get plugin metadata
$meta = new \csphere\core\plugins\Metadata();

$plugins = $meta->entries('admin', 'system');

// Create link for every plugin
$data = array('action' => 'control', 'plugins' => $plugins);

// Output results
$view = $loader->load('view');

$view->template('admin', 'system', $data);