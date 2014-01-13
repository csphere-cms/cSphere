<?php

/**
 * List of plugins with translation status
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

$short = \csphere\core\http\Input::get('get', 'short');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('languages');

$bread->add('control');
$bread->add('plugins', 'languages/plugins/short/' . $short);
$bread->trace();

// Check if translation exists
$meta = new \csphere\core\translation\Metadata();

$exists = $meta->exists($short);

if ($exists === true) {

    $plugins = $meta->plugins($short);

    // Create link for every plugin
    $data = array('short' => $short, 'plugins' => $plugins);

    // Output results
    $view = $loader->load('view');

    $view->template('languages', 'plugins', $data);
}