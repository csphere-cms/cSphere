<?php

/**
 * Config action
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
$bread->add('database');
$bread->add('admin');
$bread->add('config');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Define basic stuff
$test  = false;
$error = '';
$data  = array();

// List of cache drivers
$cache_drivers = array('none' => 'None',
                       'file' => 'File',
                       'apc'  => 'APC / APCu',
                       'wincache'  => 'WinCache',
                       'xcache' => 'XCache');

// Get post data
$post  = \csphere\core\http\Input::getAll('post');
$cache = isset($post['cache_driver']) ? $post['cache_driver'] : 'file';
$cache = isset($cache_drivers[$cache]) ? $cache : '';

$config            = array();
$config['logs']    = empty($post['logs']) ? '0' : '1';
$config['zlib']    = empty($post['zlib']) ? '0' : '1';
$config['debug']   = empty($post['debug']) ? '0' : '1';
$config['rewrite'] = empty($post['rewrite']) ? '0' : '1';
$config['ajax']    = empty($post['ajax']) ? '0' : '1';

// Check if config details are valid
if (isset($post['csphere_form'])) {

    $test = true;

    // Check for database connection and admin
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

            $db_test = $loader->load('database', $driver, $db_config, true);

            // Get admin from database
            $dm_users = new \csphere\core\datamapper\Model('users');
            $admin    = $dm_users->read(1);

            if (!isset($admin['user_name'])) {

                $error = $lang['no_user'];
            }
        }

        // Check if cache driver is working
        $ch_test = $loader->load('cache', $cache);
        $result  = $ch_test->driver();

        if ($result != $cache) {

            $error = $lang['no_cache'];
        }

        // Try to write config file
        if ($error == '') {

            $logs = $config['logs'] == '1' ? 'file' : 'none';

            $gen = array('db'     => $db_config,
                         'cache'  => $cache,
                         'logs'   => $logs,
                         'config' => $config);

            $view = $loader->load('view');

            $view->template('install', 'pattern', $gen, true);

            $config_page = $view->box();
            $config_page = "<?php\n\n" . $config_page;
            $config_file = \csphere\core\init\path() . 'csphere/config/config.php';

            $check = file_put_contents($config_file, $config_page);

            if ($check === false) {

                $error = $lang['no_cfg'];
            }
        }

    } catch (\Exception $exception) {

        // Set error to exception message
        $error = $exception->getMessage();
    }
}

// Check if test was run with success
if ($test === true AND $error == '') {

    // Show message to continue
    $previous = \csphere\core\url\Link::href('users', 'login');
    $plugin   = $lang['install'];
    $action   = $lang['config'];
    $message  = $lang['config_ok'];

    $data = array('previous'    => $previous,
                  'type'        => 'green',
                  'plugin_name' => $plugin,
                  'action_name' => $action,
                  'message'     => $message);

    // Destroy session to clear install data
    $session = new \csphere\core\session\Session();
    $session->destroy();

    // Send data to view
    $view = $loader->load('view');

    $view->template('default', 'message', $data);

} else {

    $data['error']  = $error;
    $data['config'] = $config;

    // Create cache driver dropdown
    $cache_list = array();

    foreach ($cache_drivers AS $driver => $name) {

        $active = $cache == $driver ? 'yes' : 'no';

        $ch_list[] = array('short' => $driver, 'name' => $name, 'active' => $active);
    }

    $data['cache']['drivers'] = $ch_list;

    // Send data to view
    $view = $loader->load('view');

    $view->template('install', 'config', $data);
}