<?php

/**
 * Database action
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
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('install');

// Define basic stuff
$test     = false;
$db_error = null;
$data     = array();

// List of database drivers
$db_driverlist = array('pdo_sqlsrv' => 'Microsoft SQL Server / Microsoft LocalDB',
                       'pdo_mysql'  => 'MySQL / MariaDB',
                       'pdo_pgsql'  => 'PostgreSQL',
                       'pdo_sqlite' => 'SQLite');

// Get and format post data
$post           = \csphere\core\http\Input::getAll('post');
$db             = array();
$db_driver      = isset($post['database_driver']) ? $post['database_driver'] : '';
$db_driver      = isset($db_driverlist[$db_driver]) ? $db_driver : '';
$db['driver']   = empty($db_driver) ? 'pdo_mysql' : $db_driver;
$db['host']     = isset($post['database_host']) ? $post['database_host'] : '';
$db['username'] = isset($post['database_user']) ? $post['database_user'] : '';
$db['password'] = isset($post['database_pass']) ? $post['database_pass'] : '';
$db['prefix']   = isset($post['database_prefix']) ? $post['database_prefix'] : '';
$db['schema']   = isset($post['database_schema']) ? $post['database_schema'] : '';
$db['file']     = isset($post['database_file']) ? $post['database_file'] : '';

// Check if database settings are valid
if (isset($post['csphere_form'])) {

    $test = true;

    try {

        // Init database and set as default
        $loader->load('database', $db['driver'], $db, true);

        // Get plugin metadata
        $meta = new \csphere\core\plugins\Metadata();

        $plugins = $meta->details();

        // Install database tables of all plugins
        foreach ($plugins AS $plugin) {

            $database = new \csphere\core\plugins\Database($plugin['short']);
            $exists   = $database->exists();

            if ($exists === true) {

                $database->uninstall();
                $database->install(true, false);
            }
        }

        // Install database data of all plugins
        foreach ($plugins AS $plugin) {

            $database = new \csphere\core\plugins\Database($plugin['short']);
            $exists   = $database->exists();

            if ($exists === true) {

                $database->install(false, true);
            }
        }

    } catch (\Exception $exception) {

        // Set error for form output
        $db_error = $exception;
    }
}

// Check if test was run with success
if ($test === true AND $db_error === null) {

    // Save database settings to session
    $session = new \csphere\core\session\Session();

    $session->set('db_config', serialize($db));

    // Show message to continue
    $previous = \csphere\core\url\Link::href('install', 'webmaster');
    $plugin   = $lang['install'];
    $action   = $lang['db'];
    $message  = $lang['database_ok'];

    $data = array('previous'    => $previous,
                  'type'        => 'green',
                  'plugin_name' => $plugin,
                  'action_name' => $action,
                  'message'     => $message);

    // Send data to view
    $view = $loader->load('view');

    $view->template('default', 'message', $data);

} else {

    // Check for database test errors
    $data['error'] = '';

    if (is_object($db_error)) {

        $data['error'] = $db_error->getMessage();
    }

    // Set database data
    $db['password'] = '';

    if (empty($db['prefix'])) {

        $db['prefix'] = 'csphere';
    }

    $data['database'] = $db;

    // Create database driver dropdown
    $db_list = array();

    foreach ($db_driverlist AS $driver => $name) {

        $db_list[] = array('short' => $driver, 'name' => $name);
    }

    $data['database']['drivers'] = \csphere\core\template\Form::options(
        $db_list, 'short', 'name', $db['driver']
    );

    // Send data to view
    $view = $loader->load('view');

    // Load a Javascript to hide some fields at sqlite
    \csphere\core\template\Hooks::javascript('install', 'db.js');

    $view->template('install', 'db', $data);
}