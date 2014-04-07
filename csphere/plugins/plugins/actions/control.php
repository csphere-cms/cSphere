<?php

/**
 * List of plugins that provide plugins management
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('plugins', 'control');
$bread->trace();

// Get plugin metadata
$meta = new \csphere\core\plugins\Metadata();

$plugins = $meta->details();

// Count of installed plugins
$count  = count($plugins);

// Create link for every plugin
$data = ['count' => $count, 'plugins' => $plugins];

// Manipulate data array
foreach ($data['plugins'] as $plugin) {

    $short = $plugin['short'];

    $marketTool = new \csphere\core\market\Tools($short, 'plugin');

    $data['plugins'][$short]['removeable'] = $marketTool->uninstall();
}

// Default plugin not able to uninstall

$data['plugins']['default']['removeable'] = false;

// Output results
$view = $loader->load('view');

$view->template('plugins', 'control', $data);
