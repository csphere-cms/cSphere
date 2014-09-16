<?php

/**
 * Create action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Sites
 * @author    Daniel Burke and thanks to Martin Ederer <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('sites', 'manage');
$bread->add('create');
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Create('sites');

$t = new stdClass();
$t->tags = '';

// Define closure to execute before record is send to database
$record = function ($data) use ($t) {

    $t->tags = $data['site_tags'];
    unset($data['site_tags']);

    return $data;
};

// Define closure to execute before record is send to database
$afterRecord = function ($data) use ($t) {

    \csphere\plugins\tags\classes\Tags::parseInputTags(
        $t->tags, 'sites', $data['site_id']
    );

    return $data;
};

$rad->callRecord($record);

$rad->callAfterRecord($afterRecord);

// Define closure to execute before data is send to template
$data = function ($data) {

    \csphere\plugins\tags\classes\Tags::initTagInput();
    $data['site_tags'] = '';

    return $data;
};

$rad->callData($data);

// Delegate action
$rad->delegate();
