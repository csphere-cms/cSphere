<?php

/**
 * File Validation
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
     * File Validate
     *
     * @category  Core
     * @package   Files
     * @author    Daniel Schalla <contact@csphere.eu>
     * @copyright 2013 cSphere Team
     * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
     * @link      http://www.csphere.eu
     **/

/**
 * Class Validate
 *
 * @category  Core
 * @package   Files
 * @author    Daniel Schalla <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 */

class Validate
{
    /**
     * @var array File Location
     */

    private $_file;

    /**
     * Saves the File which must be validated
     *
     * @param array $file file Location
     */
    public function __construct($file)
    {

        if (file_exists($file['tmp_name'])) {
            $this->_file = $file;
            return true;
        } else {
            return false;
        }

    }

    /**
     * Check the file in dependency on a validationSet
     * on its mime and file extension
     *
     * @param string $validationSet Defines the ValidationSet (e.g. image)
     * @param bool   $mime          Flag for Mime Check
     * @param bool   $fileEnding    Flag for File EndingCheck
     *
     * @throws \ErrorException
     *
     * @return bool
     **/

    public function check($validationSet, $mime = true, $fileEnding = true)
    {

        $validate = true;

        if (!empty(Validate::$_fileEnding[$validationSet])
            && !empty(Validate::$_mime[$validationSet])
        ) {
            if ($mime) {
                $validate = $this->_mimeCheck($validationSet);
            }

            if ($fileEnding && $validate) {
                $validate = $this->_fileEndingCheck($validationSet);
            }
        } else {
            throw new \ErrorException('Validation Set does not exist!');
        }

        return $validate;
    }

    /**
     * Compares file mime with filter set
     *
     * @param string $validationSet Defines the ValidationSet (e.g. image)
     *
     * @return bool
     */

    private function _mimeCheck($validationSet)
    {
        $validate = false;
        $whiteList = Validate::$_mime[$validationSet];

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($this->_file['tmp_name']);

        foreach ($whiteList as $entry) {
            if ($mime == $entry) {
                $validate = true;
                break;
            }
        }

        return $validate;
    }

    /**
     * Compares file extension with filter set
     *
     * @param string $validationSet Defines the ValidationSet (e.g. image)
     *
     * @return bool
     */
    private function _fileEndingCheck($validationSet)
    {
        $validate = false;
        $whiteList = Validate::$_fileEnding[$validationSet];

        $ext = pathinfo($this->_file['name'], PATHINFO_EXTENSION);

        foreach ($whiteList as $entry) {
            if ($ext == $entry) {
                $validate = true;
                break;
            }
        }

        return $validate;
    }


    /**
     * Defines several set of allowed file endings depending on filter
     *
     * @var array
     */
    /*private static $_fileEnding = [
        "image" => ["jpeg", "jpg", "png", "gif"],
    ];*/

    /**
     * Defines several set of allowed mime types depending on filter
     *
     * @var array
     */
    /*
    private static $_mime = [
        "image" => ["image/jpeg", "image/png", "image/gif"],
    ];
    */
}
