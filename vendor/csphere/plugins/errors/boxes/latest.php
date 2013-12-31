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

$data = array();

$path = \csphere\core\init\path() . 'csphere/logs/errors/';

$files = \csphere\core\files\File::search($path, true, array('info.txt'));

$data['files'] = array();

$count = count($files);
$stop  = ($count > 5) ? 5 : $count;

for ($i = 0; $i < $stop; $i++) {

    $name    = explode('.log', $files[$i], 2);
    $content = file_get_contents($path . $files[$i]);
    $entries = substr_count($content, "--------\n");

    $data['files'][] = array('date'    => $name[0],
                             'entries' => $entries);
}

$view = $loader->load('view');

$view->template('errors', 'box_latest', $data, true);