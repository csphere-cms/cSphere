<?php
/**
 * Reset ...
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$access = new \csphere\plugins\access\classes\Handler();
var_dump($access->initiateDefault("access"));
die();