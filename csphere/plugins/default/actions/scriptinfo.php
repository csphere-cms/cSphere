<?php

/**
 * License information about this software
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Default
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$loader = \csphere\core\service\Locator::get();

$year = date('Y');

$data = ['this_year' => $year];

// Start template engine and add content
$view = $loader->load('view');

$view->template('default', 'scriptinfo', $data);