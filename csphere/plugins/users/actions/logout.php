<?php

/**
 * User logout message
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('users');
$bread->add('logout');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('users');

// Clear authentication data
$auth = new \csphere\core\authentication\Users();
$auth->logout();

// Get request and language content
$dirname = \csphere\core\http\Request::get('dirname');
$plugin  = $lang['users'];
$logout  = $lang['logout'];
$message = $lang['logout_true'];

// Set data for template
$data = ['tpl'         => 'message',
         'type'        => 'green',
         'action_name' => $logout,
         'plugin_name' => $plugin,
         'message'     => $message,
         'previous'    => $dirname];

$view = $loader->load('view');

$view->template('default', 'message', $data);