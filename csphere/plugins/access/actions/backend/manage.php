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


$access = new \csphere\plugins\access\classes\Check("access");
if ($access->checkAccess("groupread") || $access->checkAccess("access.read")) {
    $loader = \csphere\core\service\Locator::get();

    // Add breadcrumb navigation
    $bread = new \csphere\core\template\Breadcrumb('admin');
    $bread->add('system');
    $bread->plugin('access', 'control');
    $bread->trace();

    // Get plugin metadata
    $meta = new \csphere\core\plugins\Metadata();

    $plugins = $meta->details();

    // Output results
    $view = $loader->load('view');

    $path = \csphere\core\init\path();

    $tmpPlugins = [];
    $count = 0;

    foreach ($plugins as $plugin) {
        $file = $path . 'csphere/plugins/' . $plugin['short'] . '/access.xml';

        if (file_exists($file)) {
            $tmpPlugins[] = $plugin;
            $count++;
        }
    }

    $plugins = $tmpPlugins;

    $data = ['count' => $count, 'plugins' => $plugins];

    $view->template('access', 'manage', $data);
} else {
    die("Sorry, you got no permissions for this area.");
}
