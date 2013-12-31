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
$bread = new \csphere\core\template\Breadcrumb('database');

$bread->add('control');
$bread->add('tables');
$bread->trace();

// Collect table information
$data = array('tables' => array(), 'count' => 0);

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
        $name     = ($table == $plugin['short']) ? '' : explode('_', $table, 2)[1];
        $dm_table = new \csphere\core\datamapper\Finder($plugin['short'], $name);
        $records  = $dm_table->count();

        $data['tables'][] = array('table'   => $table,
                                  'plugin'  => $plugin['short'],
                                  'records' => $records);
    }
}

// Output results
$view = $loader->load('view');

$view->template('database', 'tables', $data);