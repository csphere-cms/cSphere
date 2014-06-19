<?php

/**
 * Server disk space information
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Environment
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('system');
$bread->plugin('environment', 'control');
$bread->add('space');
$bread->trace();

// Collect disk space information
$data          = [];
$path          = \csphere\core\init\path();
$free          = disk_free_space($path);
$data['free']  = \csphere\core\files\File::size($free, 0);
$total         = disk_total_space($path);
$data['total'] = \csphere\core\files\File::size($total, 0);
$used          = $total - $free;
$data['used']  = \csphere\core\files\File::size($used, 0);

$data['free_percent']  = round($free * 100 / $total) . ' %';
$data['used_percent']  = round($used * 100 / $total) . ' %';
$data['total_percent'] = '100 %';

// Output results
$view = $loader->load('view');

$view->template('environment', 'space', $data);
