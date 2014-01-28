<?php

/**
 * Details of PHP configuration
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
$bread->add('php');
$bread->trace();

// Collect PHP extension information
$data               = array();
$data['extensions'] = array();
$extensions         = get_loaded_extensions();

natcasesort($extensions);

foreach ($extensions AS $ext) {

    $data['extensions'][] = array('name' => $ext);
}

// Collect PHP settings information
$short_open_tag              = ini_get('short_open_tag');
$data['short_open_tag']      = empty($short_open_tag) ? 0 : 1;
$open_basedir                = ini_get('open_basedir');
$data['open_basedir']        = empty($open_basedir) ? 0 : 1;
$file_uploads                = ini_get('file_uploads');
$data['file_uploads']        = empty($file_uploads) ? 0 : 1;
$allow_url_fopen             = ini_get('allow_url_fopen');
$data['allow_url_fopen']     = empty($allow_url_fopen) ? 0 : 1;
$allow_url_include           = ini_get('allow_url_include');
$data['allow_url_include']   = empty($allow_url_include) ? 0 : 1;
$post_max_size               = ini_get('post_max_size');
$data['post_max_size']       = $post_max_size;
$upload_max_filesize         = ini_get('upload_max_filesize');
$data['upload_max_filesize'] = $upload_max_filesize;
$memory_limit                = ini_get('memory_limit');
$data['memory_limit']        = $memory_limit;
$max_input_time              = ini_get('max_input_time');
$data['max_input_time']      = $max_input_time;
$max_execution_time          = ini_get('max_execution_time');
$data['max_execution_time']  = $max_execution_time;

// Output results
$view = $loader->load('view');

$view->template('environment', 'php', $data);