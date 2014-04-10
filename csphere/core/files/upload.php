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
     * Uploads a file into the storage folder
     *
     * @param array  $file       Array of the file which should be uploaded,
     * using the $_FILES Array
     * @param string $plugin     Plugin Name
     * @param string $customName Rename File to $name
     * @param string $validate   defines which filter to use from the Validation
     * Class
     *
     * @return array
     **/

    public function uploadFile($file,$plugin,$customName = "")
    {
        //Determine if the File Array is consistent
        if ($this->_controlConsistency($file)) {

            //Try to upload the file in our destination folder
            if ($this->moveFile($file, $plugin, $customName)) {
                $return=true;
            } else {
                $return=false;
            }
        } else {
            $return=false;
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

        return (boolean) $consistent;
    }

    /**
     * Move the uploaded file
     *
     * @param array  $file       File Array
     * @param string $plugin     Plugin Name
     * @param string $customName Customname for the final file
     *
     * @return string
     **/

    public function moveFile($file,$plugin,$customName)
    {

        $path="storage/uploads/".$plugin."/";

        $this->createFolder($path);

        if ($customName != "") {
            $filename = $customName;
        } else {
            $filename = $file['name'];
        }

        if (move_uploaded_file($file['tmp_name'], $path.$filename)) {
            $filePath = $path.$filename;
        } else {
            $filePath = "";
        }

        return $filePath;
    }

    /**
     * Create a destination Folder
     *
     * @param string $path Filepath of the Folder
     *
     * @return boolean
     **/

    public function createFolder($path)
    {

        if (!is_dir($path)) {
            $res = mkdir($path);
        } else {
            $res = false;
        }

        return $res;
    }

}
