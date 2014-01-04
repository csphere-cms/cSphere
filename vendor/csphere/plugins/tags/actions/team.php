<?php

/**
 * Team action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Tags
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Get record option for team
$dm_options = new \csphere\core\datamapper\Options('tags');
$options    = $dm_options->load();

// Get RAD class for this action
$rad = new \csphere\core\rad\View('tags');

$rad->map('team', 'view');

// Set ID if not part of URL
$rid = (int)$options['main_id'];

$rad->delegate($rid);