<?php

/**
 * File Uploads
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Files
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\files;

/**
 * File Uploads
 *
 * @category  Core
 * @package   Files
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Upload
{
    /**
     * @var String Defines after which ruleset the validation class controls
     */

    private $_filter = "";

    /**
     * Sets the filter for the validation class
     *
     * @param string $filter FilterSet (See Validate)
     *
     * @return void
     */

    public function setFilter($filter)
    {
        $this->_filter = $filter;
    }

    /**
     * Uploads a file into the storage folder
     *
     * @param array $file Array of the file which should be uploaded,
     * using the $_FILES Array
     * @param string $plugin Plugin Name
     * @param string $customName Rename File to $name
     * Class
     *
     * @return array
     **/

    public function uploadFile($file, $plugin, $customName = "")
    {

        $validate = new Validate($file);

        if (!empty($this->_filter) && !$validate->check($this->_filter)) {
            return false;
        }

        //Determine if the File Array is consistent
        if (!$this->_controlConsistency($file)) {
            return false;
        }

        $customName = $this->_sanitizeName($customName);

        //Try to upload the file in our destination folder
        if ($this->_moveFile($file, $plugin, $customName)) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    /**
     * Controls if our $file Array consists all data we require
     *
     * @param array $file The child of the $_FILES
     *
     * @return boolean
     **/

    private function _controlConsistency($file)
    {
        $consistent = 1;

        if ($file['error'] != 0) {
            $consistent = 0;
        }

        if (empty($file['tmp_name'])) {
            $consistent = 0;
        }

        if ($file['size'] == 0) {
            $consistent = 0;
        }

        return (boolean)$consistent;
    }

    /**
     * Move the uploaded file
     *
     * @param array $file File Array
     * @param string $plugin Plugin Name
     * @param string $customName Customname for the final file
     *
     * @return string
     */

    private function _moveFile($file, $plugin, $customName)
    {

        $path = "csphere/storage/uploads/" . $plugin . "/";

        $this->createFolder($path);

        if ($customName != '') {
            $filename = $customName;
        } else {
            $filename = $file['name'];
        }

        if (move_uploaded_file($file['tmp_name'], $path . $filename)) {
            $filePath = $path . $filename;
        } else {
            $filePath = "";
        }

        return $filePath;
    }

    /**
     * Create a destination Folder
     *
     * @param string $path Filepath of the Folder
     * @throws \ErrorException
     *
     * @return boolean
     **/

    public function createFolder($path)
    {

        if (!is_dir($path)) {
            $res = mkdir($path);
            if (!$res) {
                throw new \ErrorException("Couldn't create folder: " . $path);
            }
        } else {
            $res = false;
        }

        return $res;
    }


    /**
     * Filters the name string
     * @ToDo: Filter for invalid characters, only allow [1-9A-Za-z]
     *
     * @param $name String
     *
     * @return String
     **/

    private function _sanitizeName($name)
    {

        $name = str_replace(" ", "-", $name);

        return $name;
    }

}
