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

// Define order columns
$order = ['blog_title','blog_date'];

// Define closure to execute before finder fetches results
$search = function ($object) {

    \csphere\plugins\tags\classes\Tags::joinTags($object, "blog");
    $object->groupBy('blog_id');

    return $object;
};

$rad->callFinder($search);

$rad->search(['blog_title', 'tag_name']);

$rad->delegate('blog_date', $order);
