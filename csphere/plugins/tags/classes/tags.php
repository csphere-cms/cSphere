<?php
/**
 * Tags Functions
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
 * Tags Functions
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
class Tags
{

    /**
     * Constructor to create an instance of the tags class.
     */
    public function __construct()
    {
        self::initTagInput();
    }

    /**
     * Checks whether a tag exists. The complete tag array will be returned or
     * an empty array if the tag does not exist.
     *
     * @param string $tag A string with a tag. This string is trimmed.
     *
     * @return mixed empty array if the tag doesn't exist, the array of the tag else.
     */
    public static function existTag($tag)
    {
        $tag = trim($tag);

        $tag_finder = new \csphere\core\datamapper\Finder('tags');
        $tag = $tag_finder->where('tag_name', '=', $tag)->first();

        return (count($tag) > 0) ? $tag : [];
    }

    /**
     * Checks whether a tag is used in a plugin.
     *
     * @param string  $tag        A string with the name of the tag.
     * @param string  $plugin     The name of the plugin that uses the tag
     * @param integer $plugin_fid The ID of the entry in the plugin
     *
     * @return bool returns true if the plugin uses at the given plugin_fid the tag
     * with the given name
     */
    public static function usedTag($tag, $plugin, $plugin_fid)
    {
            $tag_plugin_finder = new \csphere\core\datamapper\Finder(
                'tags', 'plugin'
            );

            $tagPlugin = $tag_plugin_finder
                ->where('plugin_name', '=', $plugin)
                ->where('plugin_fid', '=', $plugin_fid)
                ->join('tags', '', 'tag_id', 'tag_id')
                ->where('tag_name', '=', $tag)
                ->first();

            return (count($tagPlugin) > 0);
    }

    /**
     * Returns all the tags used by a plugin. If plugin_fid is not set all
     * tags used in the plugin are returned. In case of plugin_fid just the
     * tags of a specific entry are returned.
     *
     * @param string  $plugin     The name of the plugin that uses the tag
     * @param integer $plugin_fid The ID of the entry in the plugin.
     *
     * @return mixed returns all information about the tags used in the given entry
     * of the given module
     */
    public static function usedTags($plugin, $plugin_fid = 0)
    {
        $tag_plugin_finder = new \csphere\core\datamapper\Finder(
            'tags', 'plugin'
        );

        // ignore the plugin_fid
        if ($plugin_fid > 0) {
            $tag_plugin_finder = $tag_plugin_finder
                ->where('plugin_fid', '=', $plugin_fid);
        }

        // get the data, maybe with the filter
        $tags = $tag_plugin_finder
            ->where('plugin_name', '=', $plugin)
            ->join('tags', '', 'tag_id', 'tag_id')
            // TODO hier die kompletten Tabellennamen wieder entfernen
            ->columns("csphere_tags.tag_id, tag_name, tag_since")
            ->groupBy("csphere_tags.tag_id")

            ->find(0, 0);

        return $tags;
    }

    /**
     * Method to use a tag in a plugin. This method first checks whether this tag
     * is already used. In this case false will be returned. If for the given
     * tag name no tag exists then this tag will be created and then referenced.
     *
     * @param string  $tag        A string with the name of the tag.
     * @param string  $plugin     The name of the plugin that uses the tag
     * @param integer $plugin_fid The ID of the entry in the plugin
     *
     * @return bool returns true if a new connection was generated. false if the tag
     * to plugin connection already existed.
     */
    public static function useTag($tag, $plugin, $plugin_fid)
    {
        if (self::usedTag($tag, $plugin, $plugin_fid)) {
            return false;
        } else {
            // Get the tag
            $tagArray = self::existTag($tag);

            if (empty($tagArray)) {
                $tagArray = \csphere\plugins\tags\classes\TagsHelper::addTag($tag);
            }

            $dm_tag_plugin = new \csphere\core\datamapper\Model('tags', 'plugin');
            $tag_plugin = $dm_tag_plugin->create();

            $tag_plugin['tag_id'] = $tagArray['tag_id'];
            $tag_plugin['plugin_name'] = $plugin;
            $tag_plugin['plugin_fid'] = $plugin_fid;

            $dm_tag_plugin->insert($tag_plugin);

            return true;
        }
    }

    /**
     * Returns all the tags used by a plugin. If plugin_fid is not set all
     * tags used in the plugin are returned. In case of plugin_fid just the
     * tags of a specific entry are returned.
     *
     * @param string  $plugin     The name of the plugin that uses the tag
     * @param integer $plugin_fid The ID of the entry in the plugin.
     *
     * @return mixed returns all information about the tags used in the given entry
     * of the given module
     */
    public static function usedTagsNamesAsString($plugin, $plugin_fid = 0)
    {
        $tags = self::usedTags($plugin, $plugin_fid);

        $tagsAsString = "";
        foreach ($tags AS $tag) {
            $tagsAsString .= $tag['tag_name'];
            $tagsAsString .= ",";
        }

        return substr($tagsAsString, 0, -1);
    }

    /**
     * Takes the given input, splits the input at the comma (,) and creates
     * connections for all the given tags.
     *
     * @param string  $input      A string with names of tags, comma-separated
     * @param string  $plugin     The name of the plugin that uses the tag
     * @param integer $plugin_fid The ID of the entry in the plugin
     *
     * @return void this function doesn't return anything
     */
    public static function parseInputTags($input, $plugin, $plugin_fid)
    {
        $input_explode = explode(",", $input);

        \csphere\plugins\tags\classes\TagsHelper::removeTagConnection(
            $plugin, $plugin_fid
        );

        foreach ($input_explode AS $tag) {
            $tag = trim($tag);
            self::useTag($tag, $plugin, $plugin_fid);
        }
    }

    /**
     * Initializes the Bootstrap TagsInput Script.
     *
     * @return void this function doesn't return anything
     */
    public static function initTagInput()
    {
        \csphere\core\template\Hooks::stylesheet('tags', 'bootstrap-tagsinput.css');
        \csphere\core\template\Hooks::javascript(
            'tags', 'bootstrap-tagsinput.min.js'
        );
    }

    /**
     * Get all the tags as a json-String. This is intended to be used with the
     * auto suggestions at the tag input field.     *
     *
     * @return string a JSON-String with the names of all tags
     */
    public static function getTagsAsJSON()
    {
        $tag_finder = new \csphere\core\datamapper\Finder('tags');
        $tags = $tag_finder->columns('tag_name')->find(0, 0);

        // reduces the database output to just the name (xxx) instead of
        // tags_name => xxx.
        $json_tags = [];
        foreach ($tags AS $tag) {
            $json_tags[] = $tag['tag_name'];
        }

        // generate json for suggestions
        return json_encode($json_tags);
    }

    /**
     * Makes the join for using the Tags Object in list. To be used in a closure of
     * callFinder().
     *
     * @param object $object The object of the closure
     * @param string $plugin The name of the plugin
     *
     * @return void This method doesn't return anything but the given $object is
     * changed.
     */
    public static function joinTags($object, $plugin)
    {
        $object->join('tags', 'plugin', $plugin . '_id', 'plugin_fid');
        $object->join('tags', '', 'tag_id', '', 'tags', 'plugin');
    }

}