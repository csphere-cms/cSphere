<?php

/**
 * Handle options of plugins
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\datamapper;

/**
 * Handle options of plugins
 *
 * @category  Core
 * @package   Datamapper
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Options
{
    /**
     * Name of target plugin
     **/
    private $_plugin;

    /**
     * Database service object
     **/
    private $_database = null;

    /**
     * Prepare values that are needed for later usage
     *
     * @param string $plugin Plugin name
     *
     * @return \csphere\core\datamapper\Options
     **/

    public function __construct($plugin)
    {
        // Set plugin name
        $this->_plugin = $plugin;

        // Get database service object
        $loader = \csphere\core\service\Locator::get();

        $this->_database = $loader->load('database');
    }

    /**
     * Load all options of a plugin
     *
     * @return array
     **/

    public function load()
    {
        // Construct query and fetch result
        $columns = 'option_name, option_value';
        $where   = array('option_plugin', '=', $this->_plugin);

        $sql = \csphere\core\sql\DML::select('options', '', $columns, $where);

        $all = $this->_database->query($sql['statement'], $sql['input'], 0, 0);

        // Format array for easier usage
        $options = array();

        foreach ($all AS $one) {

            $options[$one['option_name']] = $one['option_value'];
        }

        return $options;
    }

    /**
     * Save all options of a plugin
     *
     * @param array $options Options as an array
     *
     * @return boolean
     **/

    public function save(array $options)
    {
        // Construct query and fetch serials
        $columns = 'option_id, option_name';
        $where   = array('option_plugin', '=', $this->_plugin);

        $sql = \csphere\core\sql\DML::select('options', '', $columns, $where);

        $all = $this->_database->query($sql['statement'], $sql['input'], 0, 0);

        // Update plugin options
        foreach ($all AS $one) {

            $name = $one['option_name'];

            // Check if option was given
            if (isset($options[$name])) {

                $assoc = array('option_value' => $options[$name]);

                $sql = \csphere\core\sql\DML::update(
                    'options', $assoc, 'option_id', $one['option_id']
                );

                $this->_database->exec($sql['statement'], $sql['input']);
            }
        }

        return true;
    }
}