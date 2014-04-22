<?php
/**
 * Tags Helper functions
 *
 * PHP Version 5
 *
 * @category  Plugin
 * @package   Tags
 * @author    Eike Broda <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\tags\classes;

/**
 * Tags Helper Functions
 *
 * PHP Version 5
 *
 * @category  Plugin
 * @package   Tags
 * @author    Eike Broda <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/
class TagsHelper
{


    /**
    * Remove the connection between plugin und tags.
    *
    * @param string  $plugin     The name of the plugin that uses the tag
    * @param integer $plugin_fid The ID of the entry in the plugin
    *
    * @return void this function doesn't return anything
    */
    public static function removeTagConnection($plugin, $plugin_fid)
    {
        $tag_plugin_finder = new \csphere\core\datamapper\Finder(
            'tags', 'plugin'
        );

        // remove the data
        $tag_plugin_finder
            ->where('plugin_name', '=', $plugin)
            ->where('plugin_fid', '=', $plugin_fid)
            ->remove();
    }

    /**
    * Add another tag to the tag database. This functions previous tests whether
    * the tag already exists. In this case the existing tag is returned.
    *
    * @param string $tag The tag to add to the database.
    *
    * @return mixed tagArray the complete array of the give tag
    */
    public static function addTag($tag)
    {
        $tag = trim($tag);

        $tagArray = \csphere\plugins\tags\classes\Tags::existTag($tag);

        if (empty($tagArray)) {
            $dm_tag = new \csphere\core\datamapper\Model('tags');
            $tag_plugin = $dm_tag->create();

            $tag_plugin['tag_name'] = $tag;
            $tag_plugin['tag_since'] = time();

            return $dm_tag->insert($tag_plugin);
        } else {
            return $tagArray;
        }
    }
}
