<?php

/**
 * Provides XML file handling for database schemas
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
 * Provides XML file handling for database schemas
 *
 * @category  Core
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Database extends Base
{
    /**
     * Determine the driver specific source file
     *
     * @param string $type Type of target, e.g. plugin
     * @param string $name Directory name of the target
     * @param string $lang Language if more than one is possible
     *
     * @return string
     **/

    protected function file($type, $name, $lang)
    {
        unset($lang);

        $file = '';

        if ($type == 'plugin') {

            $file = 'csphere/plugins/'. $name . '/database.xml';
        }

        return $file;
    }

    /**
     * Change data array for easier usage
     *
     * @param array $array Formated array generated earlier
     *
     * @return array
     **/

    protected function change(array $array)
    {
        // Shorten array depth for simple elements
        $array['plugin'] = $array['plugin'][0]['value'];

        if (isset($array['tables'])) {

            // Shorten array depth for array elements
            $array['tables'] = $array['tables'][0]['table'];

            // Shorten tables as good as possible
            $tables_c = count($array['tables']);

            for ($i = 0; $i < $tables_c; $i++) {

                $array['tables'][$i] = $this->_table($array['tables'][$i]);
            }
        }

        // Check for data array
        if (empty($array['data'])) {

            $array['data'] = array();
        } else {

            $array['data'] = $this->_data($array['data'][0]);
        }

        return $array;
    }

    /**
     * Change table sub-array for easier usage
     *
     * @param array $table One table out of the data array
     *
     * @return array
     **/

    private function _table(array $table)
    {
        $table['name'] = $table['attr'][0]['name'];
        unset($table['attr']);

        $table['columns'] = $table['columns'][0]['column'];
        $table['primary'] = $table['primary'][0]['column'];

        // Shorten uniques as good as possible
        if (isset($table['uniques'])) {

            $table['uniques'] = $this->loopattr($table['uniques'][0]['unique']);
        } else {

            $table['uniques'] = array();
        }

        // Shorten indexes as good as possible
        if (isset($table['indexes'])) {

            $table['indexes'] = $this->loopattr($table['indexes'][0]['index']);
        } else {

            $table['indexes'] = array();
        }

        // Shorten foreigns as good as possible
        if (isset($table['foreigns'])) {

            $new               = array();
            $table['foreigns'] = $table['foreigns'][0]['foreign'];

            foreach ($table['foreigns'] AS $foreign) {

                $new[] = array('table'  => $foreign['attr'][0]['table'],
                               'column' => $foreign['column']);
            }

            $table['foreigns'] = $new;

        } else {

            $table['foreigns'] = array();
        }

        return $table;
    }

    /**
     * Change data sub-array for easier usage
     *
     * @param array $data Data array
     *
     * @return array
     **/

    private function _data(array $data)
    {
        // Shorten insert as good as possible
        if (isset($data['insert'])) {

            $data['insert'] = $this->loopattr($data['insert']);
        }

        // Shorten update as good as possible
        if (isset($data['update'])) {

            $data['update'] = $this->loopattr($data['update']);
        }

        // Shorten delete as good as possible
        if (isset($data['delete'])) {

            $data['delete'] = $this->loopattr($data['delete']);
        }

        return $data;
    }
}