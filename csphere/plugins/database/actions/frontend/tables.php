<?php

/**
 * Database tables provided by plugins
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Database
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('database', 'control');
$bread->add('tables');
$bread->trace();

// Get language data
$lang = \csphere\core\translation\Fetch::keys('database');

// Collect table information
$data = ['tables' => [], 'count' => 0, 'error' => ''];

$meta = new \csphere\core\plugins\Metadata();

$plugins = $meta->details();

// Get database tables of all plugins
foreach ($plugins AS $plugin) {

    $database       = new \csphere\core\Plugins\Database($plugin['short']);
    $tables         = $database->tables();
    $data['count'] += count($tables);

    // Get name and records of every table
    foreach ($tables AS $table) {

        // Hope that all tables follow the unwritten naming rules
        $error   = '';
        $name    = '';
        $records = '';

        if ($table != $plugin['short']) {

            $split = explode('_', $table, 2);

            if (isset($split[1]) && $split[0] == $plugin['short']) {

                $name = $split[1];

            } else {

                $name  = null;
                $error = $lang['table_name_error'] . ': ' . $table
                       . ' (' . $plugin['short'] . ')' . "\n";

                $data['error'] .= $error;
            }
        }

        // Get amount of entries from that table
        if ($error == '') {

            try {
                $dm_table = new \csphere\core\datamapper\Finder(
                    $plugin['short'], $name
                );

                $records = $dm_table->count();

            } catch (\Exception $exception) {

                $data['error'] .= $exception->getMessage() . "\n";
            }
        }

        $data['tables'][] = ['table'   => $table,
                             'plugin'  => $plugin['short'],
                             'records' => $records];
    }
}

// Output results
$view = $loader->load('view');

$view->template('database', 'tables', $data);
