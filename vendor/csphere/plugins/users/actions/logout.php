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

 // Get view object
$loader = \csphere\core\service\Locator::get();
$view   = $loader->load('view');

// Clear authentication data
$auth = new \csphere\core\authentication\Users();
$auth->logout();

// Get request and language content
$dirname = \csphere\core\http\Request::get('dirname');
$plugin  = \csphere\core\translation\Fetch::key('users', 'users');
$logout  = \csphere\core\translation\Fetch::key('users', 'logout');
$message = \csphere\core\translation\Fetch::key('users', 'logout_true');

// Set data for template
$data = array('tpl'         => 'message',
              'type'        => 'green',
              'action_name' => $logout,
              'plugin_name' => $plugin,
              'message'     => $message,
              'previous'    => $dirname);

$view->template('default', 'message', $data);