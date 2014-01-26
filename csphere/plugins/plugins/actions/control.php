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
$bread = new \csphere\core\template\Breadcrumb('plugins');

$bread->add('control');
$bread->trace();

// Get plugin metadata
$meta = new \csphere\core\plugins\Metadata();

$plugins = $meta->details();

// Count of installed plugins
$count  = count($plugins);

// Create link for every plugin
$data = array('count' => $count, 'plugins' => $plugins);

// Manipulate data array
foreach($data['plugins'] as $plugin)
{
    $short = $plugin['short'];
    
    $removeable = \csphere\plugins\plugins\classes\Check::uninstall($short, false);
    
    $data['plugins'][$short]['removeable'] = $removeable;
}

// Output results
$view = $loader->load('view');

$view->template('plugins', 'control', $data);