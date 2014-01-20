<?php

/**
 * Admin action
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

$bread->add('lang');
$bread->add('mail');
$bread->add('db');
$bread->add('webmaster');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Define basic stuff
$test  = false;
$error = '';
$data  = array();

// Get post data
$post = \csphere\core\http\Input::getAll('post');

// Check if admin details are valid
if (isset($post['csphere_form'])) {

    $test = true;

    // Check for too short username or password
    $user_len = strlen($post['user_name']);
    $pass_len = strlen($post['user_password']);

    if ($user_len < 4 OR $pass_len < 4) {

        $error = $lang['too_short'];

    } else {

        // Store admin user inside database
        try {

            // Get database connection data
            $session = new \csphere\core\session\Session();

            $db_config = array();
            $db_data   = array('driver', 'host', 'username', 'password',
                               'prefix', 'schema', 'file');

            foreach ($db_data AS $key) {

                $db_config[$key] = $session->get('db_' . $key);
            }

            // Establish connection
            $driver = $db_config['driver'];

            if (empty($driver)) {

                $error = $lang['no_db'];

            } else {

                // Init database and set as default
                $loader->load('database', $driver, $db_config, true);

                // Save user to database
                $dm_users = new \csphere\core\datamapper\Model('users');

                $password = $post['user_password'];
                $password = \csphere\core\authentication\Password::hash($password);

                $user                  = $dm_users->create();
                $user['user_since']    = time();
                $user['user_lang']     = $session->get('user_lang');
                $user['user_name']     = $post['user_name'];
                $user['user_email']    = $post['user_email'];
                $user['user_password'] = $password;

                $dm_users->insert($user);
            }

        } catch (\Exception $exception) {

            // Set error to exception message
            $error = $exception->getMessage();
        }
    }
}

// Check if test was run with success
if ($test === true AND $error == '') {

    // Show message to continue
    $previous = \csphere\core\url\Link::href('install', 'conf');
    $plugin   = $lang['install'];
    $action   = $lang['webmaster'];
    $message  = $lang['admin_ok'];

    $data = array('previous'    => $previous,
                  'type'        => 'green',
                  'plugin_name' => $plugin,
                  'action_name' => $action,
                  'message'     => $message);

    // Send data to view
    $view = $loader->load('view');

    $view->template('default', 'message', $data);

} else {

    $data['error']      = $error;
    $data['user_name']  = isset($post['user_name']) ? $post['user_name'] : '';
    $data['user_email'] = isset($post['user_email']) ? $post['user_email'] : '';

    // Send data to view
    $view = $loader->load('view');

    $view->template('install', 'webmaster', $data);
}