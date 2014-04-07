<?php

/**
 * Provides view functionality for html output
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   View
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\view;

/**
 * Provides view functionality for html output
 *
 * @category  Core
 * @package   View
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_HTML extends Base
{
    /**
     * Content type header
     **/
    protected $type = 'text/html; charset=UTF-8';

    /**
     * Boxes with key and a value containing their data
     **/
    private $_boxes = [];

    /**
     * List of template files with their cache key attached
     **/
    private $_files = [];

    /**
     * Theme name
     **/
    private $_theme = '';

    /**
     * Hold cache object for checks
     **/
    private $_cache = null;

    /**
     * Language shorthandle for translation
     **/
    private $_language = '';

    /**
     * Creates the view handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\view\Driver_HTML
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        // @TODO: Theme should be configurable
        if (empty($this->config['theme'])) {

            $this->config['theme'] = 'default';
        }

        $this->_theme = $this->config['theme'];

        // Set cache object
        $this->_cache = $this->loader->load('cache');

        // Get language
        $this->_language = \csphere\core\translation\Fetch::lang();
    }

    /**
     * Get theme details from cache or file
     *
     * @param boolean $boxes Get only boxes of theme
     *
     * @return array
     **/

    private function _theme($boxes = false)
    {
        // Try to load theme details from cache
        $key_boxes = 'theme_boxes_' . $this->_theme . '_' . $this->_language;
        $key_parts = 'theme_parts_' . $this->_theme . '_' . $this->_language;

        if ($boxes == true) {

            $result = $this->_cache->load($key_boxes);

        } else {

            $result = $this->_cache->load($key_parts);
        }

        // If cache loading fails prepare theme file
        if ($result == false) {

            // Load theme file name and fetch file content
            $target = new \csphere\core\themes\Checks($this->_theme);
            $dir  = $target->dirname();
            $file = $target->result();
            $file = file_get_contents($file);

            // Split theme file and get boxes
            $parts = \csphere\core\template\Theme::prepare($file, $dir);
            $boxed = \csphere\core\template\Theme::boxes($parts);

            // Save result for later requests
            $this->_cache->save($key_boxes, $boxed);
            $this->_cache->save($key_parts, $parts);

            if ($boxes == true) {

                $result = $boxed;

            } else {

                $result = $parts;
            }
        }

        return $result;
    }

    /**
     * Prepare template files
     *
     * @param string $plugin   Name of the plugin
     * @param string $template Template file name without file ending
     *
     * @return string
     **/

    private function _load($plugin, $template)
    {
        // Try to load template details from cache
        $key = 'tpl_' . $plugin . '_' . $template . '_' . $this->_language;

        // Check if key is already loaded
        if (!isset($this->_files[$key])) {

            $tpl = $this->_cache->load($key);

            // If cache loading fails prepare template file
            if ($tpl == false) {

                $tpl = \csphere\core\template\Engine::source($plugin, $template);

                // Save result for later requests
                $this->_cache->save($key, $tpl);
            }

            $this->_files[$key] = $tpl;
        }

        return $key;
    }

    /**
     * Parses the template parts
     *
     * @param array $parts Array of data per template
     *
     * @return string
     **/

    private function _parse($parts)
    {
        // Get and parse parts
        $result = '';

        foreach ($parts AS $part) {

            if (isset($part['key'])) {

                $tpl = $this->_files[$part['key']];

                $add = \csphere\core\template\Engine::parse($tpl, $part['data']);

            } else {

                $add = (string)$part;
            }

            $result .= $add . "\n";
        }

        return $result;
    }

    /**
     * Format content parts on json requests
     *
     * @param boolean $box Special case for box mode
     *
     * @return array
     **/

    protected function format($box)
    {
        if ($box == true) {

            $response = $this->_parse($this->_boxes);

            $this->_boxes = [];

            $response = ['box' => $response];

            // Load debug toolbar only if debug option is true
            if ($this->config['debug'] == true) {

                $response['debug'] = \csphere\core\template\Hooks::debug();
            }

        } else {

            $result = $this->_parse($this->content);

            // Only use boxes from theme
            $boxes = $this->_theme(true);

            $response = \csphere\core\template\Engine::boxes($boxes, $result);
        }

        return $response;
    }

    /**
     * Combine content parts on usual requests
     *
     * @param boolean $box Special case for box mode
     *
     * @return string
     **/

    protected function combine($box)
    {
        if ($box == true) {

            $response = $this->_parse($this->_boxes);

            $this->_boxes = [];

        } else {

            $result = $this->_parse($this->content);

            // Use full theme file
            $theme = $this->_theme();

            $response = \csphere\core\template\Theme::parse($theme, $result);
        }

        return $response;
    }

    /**
     * Parse content of active box
     *
     * @return string
     **/

    public function box()
    {
        $result = $this->_parse($this->_boxes);

        $this->_boxes = [];

        return $result;
    }

    /**
     * Clear boxes for template box parser
     *
     * @return boolean
     **/

    public function clear()
    {
        $this->_boxes = [];

        return true;
    }

    /**
     * Adds a template file with data to output
     *
     * @param string  $plugin   Name of the plugin
     * @param string  $template Template file name without file ending
     * @param array   $data     Array with content to use in the template
     * @param boolean $box      Defaults to false which turns box mode off
     *
     * @return boolean
     **/

    public function template(
        $plugin, $template, array $data = [], $box = false
    ) {
        // Get template key and file content
        $key = $this->_load($plugin, $template);

        // Add key with data to content or boxes
        if ($box == true) {

            $this->_boxes[] = ['key' => $key, 'data' => $data];

        } else {

            $this->content[] = ['key' => $key, 'data' => $data];
        }

        return true;
    }
}
