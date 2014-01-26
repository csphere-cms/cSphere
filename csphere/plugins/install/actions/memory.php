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

$bread->add('lang');
$bread->add('db');
$bread->add('webmaster');
$bread->add('mail');
$bread->add('memory');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Define basic stuff
$test        = false;
$cache_error = null;
$data        = array();

// List of cache drivers
$cache_drivers = array('none'     => 'None');
$cache_exists  = array('apc'      => 'APC / APCu',
                       'file'     => 'File',
                       'redis'    => 'Redis',
                       'wincache' => 'WinCache',
                       'xcache'   => 'XCache');

foreach ($cache_exists AS $short => $name) {

    if (extension_loaded($short)) {

        $cache_drivers[$short] = $name;
    }
}

// Get and format post data
$post             = \csphere\core\http\Input::getAll('post');

$cache             = array();
$cache_driver      = isset($post['cache_driver']) ? $post['cache_driver'] : '';
$cache_driver      = isset($cache_drivers[$cache_driver]) ? $cache_driver : '';
$cache['driver']   = empty($cache_driver) ? 'file' : $cache_driver;
$cache['host']     = isset($post['cache_host']) ? $post['cache_host'] : '';
$cache['password'] = isset($post['cache_pass']) ? $post['cache_pass'] : '';
$cache['timeout']  = isset($post['cache_timeout']) ? $post['cache_timeout'] : '';
$cache['port']     = isset($post['cache_port']) ? $post['cache_port'] : '';

// Check if mail settings are valid
if (isset($post['csphere_form'])) {

    $test = true;

    try {

        // Check if cache driver is working
        $ch_test = $loader->load('cache', $cache['driver'], $cache);
        $result  = $ch_test->driver();

        if ($result != $cache['driver']) {

            $cache_error = new \Exception($lang['no_cache']);
        }

    } catch (\Exception $exception) {

        // Set error for form output
        $cache_error = $exception;
    }
}

// Check if test was run with success
if ($test === true AND $cache_error === null) {

    // Save cache settings to session
    $session = new \csphere\core\session\Session();

    $session->set('cache_config', serialize($cache));

    // Show message to continue
    $previous = \csphere\core\url\Link::href('install', 'conf');
    $plugin   = $lang['install'];
    $action   = $lang['memory'];
    $message  = $lang['cache_ok'];

    $data = array('previous'    => $previous,
                  'type'        => 'green',
                  'plugin_name' => $plugin,
                  'action_name' => $action,
                  'message'     => $message);

    // Send data to view
    $view = $loader->load('view');

    $view->template('default', 'message', $data);

} else {

    // Check for cache test errors
    $data['error'] = '';

    if (is_object($cache_error)) {

        $data['error'] = $cache_error->getMessage();
    }

    // Set cache data
    $cache['password'] = '';

    if (empty($cache['timeout'])) {

        $cache['timeout'] = '5';
    }

    $data['cache'] = $cache;

    // Create cache driver dropdown
    $ch_list = array();

    foreach ($cache_drivers AS $driver => $name) {

        $ch_list[] = array('short' => $driver, 'name' => $name);
    }

    $data['cache']['drivers'] = \csphere\core\template\Form::options(
        $ch_list, 'short', 'name', $cache['driver']
    );

    // Send data to view
    $view = $loader->load('view');

    // Load a Javascript to hide some fields at sqlite
    \csphere\core\template\Hooks::javascript('install', 'memory.js');

    $view->template('install', 'memory', $data);
}