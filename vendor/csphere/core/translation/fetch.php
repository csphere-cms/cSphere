<?php

/**
 * Loads the requested language content
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Translation
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\translation;

/**
 * Loads the requested language content
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Translation
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Fetch
{
    /**
     * Language shorthandle for translation
     **/
    private static $_language = '';

    /**
     * Service loader object
     **/
    private static $_loader = null;

    /**
     * XML driver object
     **/
    private static $_xml = null;

    /**
     * Cache driver object
     **/
    private static $_cache = null;

    /**
     * View driver theme name
     **/
    private static $_theme = '';

    /**
     * Store language files that are already opened
     **/
    private static $_loaded = array();

    /**
     * Delivers the requested translation string
     *
     * @param string $plugin Plugin to use for language file
     * @param string $key    Key to search in that file
     *
     * @throws \Exception
     *
     * @return string
     **/

    public static function key($plugin, $key)
    {
        $exists = self::exists($plugin, $key);

        // Return key if it exists
        if ($exists == true) {

            $return = self::$_loaded[$plugin][$key];

        } else {

            // Empty plugin means that a theme translation is going on
            $error  = ($plugin == '') ? 'Theme' : 'Plugin "' . $plugin . '"';
            $error .= ' fails to translate this key: ' . $key;

            throw new \Exception($error);
        }

        return $return;
    }

    /**
     * Checks if a plugin contains a translation key
     *
     * @param string $plugin Plugin to use for language file
     * @param string $key    Key to search in that file
     *
     * @return boolean
     **/

    public static function exists($plugin, $key)
    {
        // Check if translation is already loaded
        if (!isset(self::$_loaded[$plugin])) {

            self::$_loaded[$plugin] = self::_cache($plugin);
        }

        $result = isset(self::$_loaded[$plugin][$key]) ? true : false;

        return $result;
    }

    /**
     * Short name of active language
     *
     * @return string
     **/

    public static function lang()
    {
        // Load language short if not done yet
        if (self::$_language == '') {

            // Get user language from session
            $session  = new \csphere\core\session\Session();
            $language = $session->get('user_lang');

            self::$_language = empty($language) ? 'en' : $language;
        }

        return self::$_language;
    }

    /**
     * Sets options to work with translation files
     *
     * @return boolean
     **/

    private static function _settings()
    {
        // Set language if not done yet
        self::lang();

        // Get basic objects
        self::$_loader = \csphere\core\service\Locator::get();

        self::$_cache = self::$_loader->load('cache');

        $view = self::$_loader->load('view');

        self::$_theme = $view->getOption('theme');
    }

    /**
     * Delivers the requested translation file
     *
     * @param string $plugin Plugin to use for language file
     *
     * @return array
     **/

    private static function _cache($plugin)
    {
        // Load cache and settings if not done yet
        if (self::$_cache == null) {

            self::_settings();
        }

        // Empty plugin means that a theme translation is going on
        if ($plugin == '') {

            $token = 'lang_theme_' . self::$_theme . '_' . self::$_language;

        } else {

            $token = 'lang_plugin_' . $plugin . '_' . self::$_language;
        }

        // Look for plugin and language inside cache
        $lang = self::$_cache->load($token);

        // If cache loading fails load it and create cache file
        if ($lang == false) {

            $lang = self::_open($plugin);

            self::$_cache->save($token, $lang);
        }

        return $lang;
    }

    /**
     * Gets the content for the requested translation file
     *
     * @param string $plugin Plugin to use for language file
     *
     * @return array
     **/

    private static function _open($plugin)
    {
        // Set XML loader if not done yet
        if (self::$_xml == null) {

            self::$_xml = self::$_loader->load('xml', 'language');
        }

        // Empty plugin means that a theme translation is going on
        if ($plugin == '') {

            $data = self::$_xml->source('theme', self::$_theme, self::$_language);

        } else {

            $data = self::$_xml->source('plugin', $plugin, self::$_language);
        }

        // Array should be a list of names with their value
        $lang = array();
        $data = $data['definitions'];

        foreach ($data AS $def) {

            $lang[$def['name']] = $def['value'];
        }

        return $lang;
    }
}