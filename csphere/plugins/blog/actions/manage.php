<?php

/**
 * List action
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Blog
 * @author    Daniel Schalla <schalla@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

 // Get RAD class for this action
$rad = new \csphere\core\rad\Listed('blog');

$rad->map('manage', 'manage');

// Define order columns
$order = ['blog_date'];

// Define closure to execute before data is send to template
$data = function ($data) {

    for ($i = 0; $i < count($data); ++$i) {
        $data[$i]['blog_tags']
            = \csphere\plugins\tags\classes\Tags::usedTagsNamesAsString(
                'blog', $data[$i]['blog_id']
            );
    }

    return $data;
};

$rad->callData($data);

// Define closure to execute before finder fetches results
$search = function ($object) {

    $object->join('tags', 'plugin', 'blog_id', 'plugin_fid');
    $object->join('tags', '', 'tag_id', '', 'tags', 'plugin');
    $object->groupBy('blog_id');

    return $object;
};

$rad->callFinder($search);

$rad->search(['blog_title', 'tag_name'], true, true);

$rad->delegate('blog_title', $order);