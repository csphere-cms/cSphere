<?php

/**
 * Language action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Install
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('install');

$bread->add('language');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Get plugin metadata
$meta = new \csphere\core\translation\Metadata();

// Check for language changes
$get_lang = \csphere\core\http\Input::get('get', 'lang');
$exists   = $meta->exists($get_lang);

if ($exists === true) {

    // Save language choice to session
    $session = new \csphere\core\session\Session();
    $session->set('user_lang', $get_lang);

    // Show message to continue
    $previous = \csphere\core\url\Link::href('install', 'database');
    $plugin   = $lang['install'];
    $action   = $lang['language'];
    $message  = $lang['language_ok'];

    $data = array('previous'    => $previous,
                  'type'        => 'green',
                  'plugin_name' => $plugin,
                  'action_name' => $action,
                  'message'     => $message);

    // Send data to view
    $view = $loader->load('view');

    $view->template('default', 'message', $data);

} else {

    // Create link for every language
    $languages = $meta->details();

    $data = array('languages' => $languages);

    // Send data to view
    $view = $loader->load('view');

    $view->template('install', 'language', $data);
}