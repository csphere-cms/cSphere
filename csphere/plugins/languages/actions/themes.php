<?php

/**
 * List of themes with translation status
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
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('languages', 'control');
$bread->add('themes', 'languages/themes/short/' . $short);
$bread->trace();

// Check if translation exists
$meta = new \csphere\core\translation\Metadata();

$exists = $meta->exists($short);

if ($exists === true) {

    $themes = $meta->themes($short);

    // Create link for every plugin
    $data = array('short' => $short, 'themes' => $themes);

    // Output results
    $view = $loader->load('view');

    $view->template('languages', 'themes', $data);
}