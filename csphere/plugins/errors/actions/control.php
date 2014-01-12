<?php

/**
 * List of latest error files
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Errors
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('errors');

$bread->add('control');
$bread->trace();

// Add data of errors
$path = \csphere\core\init\path() . 'csphere/storage/logs/errors/';

$files = \csphere\core\files\File::search($path, true, array('info.txt'));

$count = count($files);

$data = array('count' => $count, 'files' => array());

for ($i = 0; $i < $count; $i++) {

    $name = explode('.log', $files[$i], 2);

    $data['files'][] = array('date' => $name[0]);
}

$view = $loader->load('view');

$view->template('errors', 'control', $data);