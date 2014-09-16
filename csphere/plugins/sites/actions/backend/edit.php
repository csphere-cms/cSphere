<?php

/**
 * Edit action
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

// Sites ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('sites', 'manage');
$bread->add('edit', 'sites/edit/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Edit('sites');

$tags = new \csphere\plugins\tags\classes\Tags();

// Define closure to execute before record is send to database
$record = function ($data) use ($tags) {

    $tags::parseInputTags(
        $data['site_tags'], 'sites', $data['site_id']
    );

    unset($data['site_tags']);

    return $data;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($data) use ($tags) {

    $data['site_tags']= $tags::usedTagsNamesAsString(
        'sites', $data['site_id']
    );

    return $data;
};

$rad->callData($data);

// Delegate action
$rad->delegate();
