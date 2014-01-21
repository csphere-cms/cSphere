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

$bread->add('lang');
$bread->add('db');
$bread->add('webmaster');
$bread->add('mail');
$bread->add('memory');
$bread->add('conf');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Define basic stuff
$test  = false;
$error = '';
$data  = array();

// Get post data
$post  = \csphere\core\http\Input::getAll('post');

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

        // Get session for configuration data contents
        $session = new \csphere\core\session\Session();

        // Get cache data
        $cache_config = $session->get('cache_config');
        $length       = strlen($cache_config);
        $cache_config = ($length > 2) ? unserialize($cache_config) : array();

        // Get mail data
        $mail_config = $session->get('mail_config');
        $length      = strlen($mail_config);
        $mail_config = ($length > 2) ? unserialize($mail_config) : array();

        // Get db data
        $db_config = $session->get('db_config');
        $length    = strlen($db_config);
        $db_config = ($length > 2) ? unserialize($db_config) : array();

        // Get db driver
        $driver = isset($db_config['driver']) ? $db_config['driver'] : '';

        if (empty($driver)) {

            $error = $lang['no_db'];

        } else {

            // Init database and set as default
            $loader->load('database', $driver, $db_config, true);

            // Get admin from database
            $dm_users = new \csphere\core\datamapper\Model('users');
            $admin    = $dm_users->read(1);

            if (!isset($admin['user_name'])) {

                $error = $lang['no_user'];
            }
        }

        // Get cache driver
        $driver = isset($cache_config['driver']) ? $cache_config['driver'] : '';

        // Check if cache driver is working
        $ch_test = $loader->load('cache', $driver, $cache_config);
        $result  = $ch_test->driver();

        if ($result != $cache_config['driver']) {

            $error = $lang['no_cache'];
        }

        // Try to write config file
        if ($error == '') {

            $logs = $config['logs'] == '1' ? 'file' : 'none';

            $gen = array('db'     => $db_config,
                         'mail'   => $mail_config,
                         'cache'  => $cache_config,
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
    $dirname  = \csphere\core\http\Request::get('dirname');
    $previous = $dirname;
    $plugin   = $lang['install'];
    $action   = $lang['conf'];
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

    // Send data to view
    $view = $loader->load('view');

    $view->template('install', 'conf', $data);
}