<?php

/**
 * Information on Zend OPcache
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Cache
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('cache');

$bread->add('control');
$bread->add('opcache');
$bread->trace();

// Get OPcache information
$data     = array('opcache' => array());
$settings = array('enable', 'enable_cli', 'memory_consumption', 'save_comments',
                  'load_comments', 'validate_timestamps', 'revalidate_freq');

foreach ($settings AS $ini) {

    $data['opcache'][$ini] = ini_get('opcache.' . $ini);
}

$data['extension'] = extension_loaded('Zend OPcache') ? 'yes' : '';

// Output results
$view = $loader->load('view');

$view->template('cache', 'opcache', $data);