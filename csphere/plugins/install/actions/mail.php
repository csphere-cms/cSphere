<?php

/**
 * Mail action
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
$bread->add('mail');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Define basic stuff
$test       = false;
$mail_error = null;
$data       = array();

// List of mail drivers
$mail_driverlist = array('none'     => 'None',
                         'sendmail' => 'Sendmail',
                         'smtp'     => 'SMTP');

$mail_newlines = array(''        => 'Default (PHP_EOL)',
                       'linux'   => 'Linux / Apple Mac OS',
                       'windows' => 'Microsoft Windows');

// Get and format post data
$post             = \csphere\core\http\Input::getAll('post');
$mail             = array();
$mail_driver      = isset($post['mail_driver']) ? $post['mail_driver'] : '';
$mail_driver      = isset($mail_driverlist[$mail_driver]) ? $mail_driver : '';
$mail['driver']   = empty($mail_driver) ? 'sendmail' : $mail_driver;
$mail_newline     = isset($post['mail_newline']) ? $post['mail_newline'] : '';
$mail['newline']  = isset($mail_newlines[$mail_newline]) ? $mail_newline : '';
$mail['host']     = isset($post['mail_host']) ? $post['mail_host'] : '';
$mail['username'] = isset($post['mail_user']) ? $post['mail_user'] : '';
$mail['password'] = isset($post['mail_pass']) ? $post['mail_pass'] : '';
$mail['from']     = isset($post['mail_from']) ? $post['mail_from'] : '';
$mail['subject']  = isset($post['mail_subject']) ? $post['mail_subject'] : '';
$mail['timeout']  = isset($post['mail_timeout']) ? $post['mail_timeout'] : '';
$mail['port']     = isset($post['mail_port']) ? $post['mail_port'] : '';

// Check if mail settings are valid
if (isset($post['csphere_form'])) {

    $test = true;

    try {

        // Establish connection
        $mail_test = $loader->load('mail', $mail['driver'], $mail, true);

        // Try to send a mail
        $mail_test->prepare($lang['mail_test_subject'], $lang['mail_test_text']);

        $test = $mail_test->send($mail['from']);

        if ($test === false) {

            $mail_error = new \Exception($lang['mail_test_fail']);
        }

    } catch (\Exception $exception) {

        // Set error for form output
        $mail_error = $exception;
    }
}

// Check if test was run with success
if ($test === true AND $mail_error === null) {

    // Save mail settings to session
    $session = new \csphere\core\session\Session();

    foreach ($mail AS $key => $value) {

        $session->set('mail_' . $key, $value);
    }

    // Show message to continue
    $previous = \csphere\core\url\Link::href('install', 'database');
    $plugin   = $lang['install'];
    $action   = $lang['mail'];
    $message  = $lang['mail_ok'];

    $data = array('previous'    => $previous,
                  'type'        => 'green',
                  'plugin_name' => $plugin,
                  'action_name' => $action,
                  'message'     => $message);

    // Send data to view
    $view = $loader->load('view');

    $view->template('default', 'message', $data);

} else {

    // Check for mail test errors
    $data['error'] = '';

    if (is_object($mail_error)) {

        $data['error'] = $mail_error->getMessage();
    }

    // Set mail data
    $mail['password'] = '';

    if (empty($mail['timeout'])) {

        $mail['timeout'] = '5';
    }

    $data['mail'] = $mail;

    // Create mail driver dropdown
    $mail_list = array();

    foreach ($mail_driverlist AS $driver => $name) {

        $active = $mail['driver'] == $driver ? 'yes' : 'no';

        $mail_list[] = array('short'  => $driver,
                             'name'   => $name,
                             'active' => $active);
    }

    $data['mail']['drivers'] = $mail_list;

    // Create mail newline dropdown
    $mail_line = array();

    foreach ($mail_newlines AS $line => $name) {

        $active = $mail['newline'] == $line ? 'yes' : 'no';

        $mail_line[] = array('short' => $line, 'name' => $name, 'active' => $active);
    }

    $data['mail']['newlines'] = $mail_line;

    // Send data to view
    $view = $loader->load('view');

    // Load a Javascript to hide some fields at sqlite
    \csphere\core\template\Hooks::javascript('install', 'mail.js');

    $view->template('install', 'mail', $data);
}