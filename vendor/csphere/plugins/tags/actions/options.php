<?php

/**
 * Options action
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

 // Get RAD class for this action
$rad = new \csphere\core\rad\Options('tags');

// Define closure to execute before record is send to database
$record = function ($array) {

    $tag_id = '';

    if (!empty($array['main_name'])) {
        $dm_tags  = new \csphere\core\datamapper\Model('tags');
        $tag      = $dm_tags->read($array['main_name'], 'tag_name');
        $tag_id = empty($tag['tag_id']) ? '' : $tag['tag_id'];
    }

    $array['main_id'] = $tag_id;
    unset($array['main_name']);

    return $array;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($array) {

    $tag_name = '';

    if (!empty($array['main_id'])) {
        $dm_tags  = new \csphere\core\datamapper\Model('tags');
        $tag      = $dm_tags->read($array['main_id']);
        $tag_name = empty($tag['tag_name']) ? '' : $tag['tag_name'];
    }

    $array['main_name'] = $tag_name;

    return $array;
};

$rad->callData($data);

// Delegate action
$rad->delegate();