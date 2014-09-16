<?php

/**
 * Edit action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Blog
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

// Blog ID
$id = \csphere\core\http\Input::get('get', 'id');

// Add breadcrumb navigation
$bread = new \csphere\core\template\Breadcrumb('admin');
$bread->add('content');
$bread->plugin('blog', 'manage');
$bread->add('edit', 'blog/edit/id/' . $id);
$bread->trace();

// Get RAD class for this action
$rad = new \csphere\core\rad\Edit('blog');


$tags = new \csphere\plugins\tags\classes\Tags();

// Define closure to execute before record is send to database
$record = function ($data) use ($tags) {

    $tags::parseInputTags(
        $data['blog_tags'], 'blog', $data['blog_id']
    );

    unset($data['blog_tags']);

    $data['blog_date'] = time();

    return $data;
};

$rad->callRecord($record);

// Define closure to execute before data is send to template
$data = function ($data) use ($tags) {

    $data['blog_tags']= $tags::usedTagsNamesAsString(
        'blog', $data['blog_id']
    );

    return $data;
};

$rad->callData($data);

// Delegate action
$rad->delegate();
