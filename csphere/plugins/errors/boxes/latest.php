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

// Get box parameters
$params = \csphere\core\http\Input::getBox();

$limit = empty($params['limit']) ? 5 : (int)$params['limit'];

// Get files that contain error logs
$path = \csphere\core\init\path() . 'csphere/storage/logs/errors/';

$files = \csphere\core\files\File::search($path, true, ['info.txt']);

// Data array for view
$data = [];
$data['params'] = 'refresh/1';
$data['files']  = [];

$count = count($files);
$stop  = ($count > $limit) ? $limit : $count;

for ($i = 0; $i < $stop; $i++) {

    $name    = explode('.log', $files[$i], 2);
    $content = file_get_contents($path . $files[$i]);
    $entries = substr_count($content, "--------\n");

    $data['files'][] = ['date'    => $name[0],
                        'entries' => $entries];
}

$view = $loader->load('view');

$view->template('errors', 'box_latest', $data, true);
