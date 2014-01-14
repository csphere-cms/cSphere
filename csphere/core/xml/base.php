<?php

/**
 * Provides XML file handling for known schemas
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\xml;

/**
 * Provides XML file handling for known schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base extends \csphere\core\service\Drivers
{
    /**
     * Stores the cache object
     **/
    protected $cache = null;

    /**
     * Stores the local path
     **/
    protected $path = '';

    /**
     * Stores the local path
     **/
    private static $_count = array();

    /**
     * Creates the XML handler object
     *
     * @param array $config Configuration details as an array
     *
     * @return \csphere\core\xml\Base
     **/

    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->path = \csphere\core\init\path();

        $this->cache = $this->loader->load('cache');
    }

    /**
     * Try to find a source inside the cache or as a file
     *
     * @param string  $type  Type of target, e.g. plugin
     * @param string  $name  Directory name of the target
     * @param string  $lang  Language if more than one is possible
     * @param boolean $empty Return empty array if file is missing
     *
     * @throws \Exception
     *
     * @return array
     **/

    public function source($type, $name, $lang = 'en', $empty = false)
    {
        // Set key here to not let drivers accidently overcut something
        $key = 'xml_' . $this->driver() . '_' . $type . '_' . $name . '_' . $lang;

        // Try to fetch key from cache or load file otherwise
        $string = $this->cache->load($key);

        if ($string == false) {

            $file = $this->path . $this->file($type, $name, $lang);

            // Check if file exists
            if (file_exists($file)) {

                $string = file_get_contents($file);

                // Parse XML to array structure and format it
                $string = $this->_structure($string);

                // Apply driver specific changes
                $string = $this->change($string);

                // Save to cache for later usage
                $this->cache->save($key, $string);

            } elseif ($empty === true) {

                // In some cases it is not relevant if the file exists
                $string = array();

            } else {

                throw new \Exception('XML file not found: ' . $file);
            }
        }

        return $string;
    }

    /**
     * Transforms the given string to a driver specific array
     *
     * @param string $string String containing the XML content
     *
     * @return array
     **/

    public function transform($string)
    {
        // Parse XML to array structure and format it
        $string = $this->_structure($string);

        // Apply driver specific changes
        $string = $this->change($string);

        return $string;
    }

    /**
     * Converts a valid XML data string into arrays
     *
     * @param string $string The XML data string to use
     *
     * @throws \Exception
     *
     * @return array
     **/

    private function _structure($string)
    {
        // @TODO: Set XSD for validation
        // Could be possible with xmlreader extension

        // Create the parser
        $parser = xml_parser_create('UTF-8');

        // Disable uppercase usage and blank entries
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

        // Split data into values and index arrays
        $struct = xml_parse_into_struct($parser, $string, $values, $index);

        // Check for errors and free parser
        $code = xml_get_error_code($parser);

        xml_parser_free($parser);

        if ($struct == 0 OR $code != 0) {

            $error = xml_error_string($code);

            throw new \Exception($error);
        }

        // Format result set for later usage
        self::$_count = array();
        $end          = (count($values) - 2);
        $result       = $this->_format($values, $index, 1, $end);

        return $result;
    }

    /**
     * Format data as an usable array
     *
     * @param array   $values Array with value data
     * @param array   $index  Array with index data
     * @param integer $start  Start point of data loop
     * @param integer $end    End point of data loop
     *
     * @return array
     **/

    private function _format(array $values, array $index, $start, $end)
    {
        $result = array();

        // Loop threw every values array entry from start to end
        for ($i = $start; $i < $end; $i++) {

            // Prepare data for result set content
            $tag = $values[$i]['tag'];

            // Add attributes if there are any
            $attr = array();

            if (isset($values[$i]['attributes'])) {

                $attr = $values[$i]['attributes'];
            }

            // Add value if there is one
            if (isset($values[$i]['value'])) {

                $attr['value'] = $values[$i]['value'];
            }

            // Type open creates a sub loop with additional details
            if ($values[$i]['type'] == 'complete') {

                $result[$tag][] = $attr;

            } elseif ($values[$i]['type'] == 'open') {

                // Determine the end point for the sub loop
                if (isset(self::$_count[$tag])) {

                    self::$_count[$tag] = (self::$_count[$tag] + 2);

                } else {

                    self::$_count[$tag] = 1;
                }

                $stop = $index[$tag][(self::$_count[$tag])];

                // Add nested elements to result array
                $open = $this->_format($values, $index, ($i + 1), $stop);

                if ($attr != array()) {

                    $attr = array('attr' => array($attr));
                    $open = array_merge($attr, $open);
                }

                $result[$tag][] = $open;

                // Skip some steps here to not use data twice
                $i = $stop;
            }
        }

        return $result;
    }

    /**
     * Move attributes up to data array in a loop
     *
     * @param array $array Array to convert
     *
     * @return array
     **/

    protected function loopattr(array $array)
    {
        $new = array();

        foreach ($array AS $row) {

            $attr = isset($row['attr'][0]) ? $row['attr'][0] : array();

            unset($row['attr']);

            $new[] = array_merge($attr, $row);
        }

        return $new;
    }

    /**
     * Change array depth for common settings
     *
     * @param array $array Array to convert
     *
     * @return array
     **/

    protected function common(array $array)
    {
        // Shorten array depth for simple elements
        $array['vendor']    = $array['vendor'][0]['value'];
        $array['version']   = $array['version'][0]['value'];
        $array['published'] = $array['published'][0]['value'];
        $array['copyright'] = $array['copyright'][0]['value'];
        $array['license']   = $array['license'][0]['value'];
        $array['name']      = $array['name'][0]['value'];
        $array['info']      = $array['info'][0]['value'];
        $array['engine']    = $array['engine'][0];
        $array['icon']      = $array['icon'][0];
        $array['authors']   = $array['authors'][0];
        $array['contact']   = $array['contact'][0];

        // Check for optional version_max
        if (empty($array['engine']['version_max'])) {

            $array['engine']['version_max'] = '';
        }

        return $array;
    }

    /**
     * Determine the driver specific source file
     *
     * @param string $type Type of target, e.g. plugin
     * @param string $name Directory name of the target
     * @param string $lang Language if more than one is possible
     *
     * @return string
     **/

    abstract protected function file($type, $name, $lang);

    /**
     * Change data array for easier usage
     *
     * @param array $array Formated array generated earlier
     *
     * @return array
     **/

    abstract protected function change(array $array);
}