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
     * File Validation
     *
     * @category  Core
     * @package   Files
     * @author    Daniel Schalla <contact@csphere.eu>
     * @copyright 2013 cSphere Team
     * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
     * @link      http://www.csphere.eu
     **/

/**
 * Class Validation
 * @package csphere\core\files
 */

class Validation
{
    /**
     * @var string File Location
     */
    private $file;

    /**
     * Saves the File which must be validated
     * @param string $file : File Location
     */
    public function __construct($file){

        if(file_exists($file)){
            $this->file=$file;
            return true;
        }else{
            return false;
        }

    }

    /**
     * Check the file in dependency on a validationSet
     * on its mime and file extension
     *
     * @param string $validationSet
     * @param bool $mime
     * @param bool $fileEnding
     * @return bool
     */
    public function check($validationSet,$mime=true,$fileEnding=true){

        $validate=false;

        if(!empty(Validation::$fileEnding[$validationSet]) && !empty(Validation::$mime[$validationSet])){
            if($mime){
                $validate=$this->_mimeCheck($validationSet);
            }

            if($fileEnding && $validate){
                $validate=$this->_fileEndingCheck($validationSet);
            }
        }

        return $validate;
    }

    /**
     * Compares file mime with filter set
     *
     * @param string $validationSet
     * @return bool
     */
    private function _mimeCheck($validationSet){
        $validate=false;
        $whiteList=Validation::$mime[$validationSet];

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime=$finfo->file($this->file);

        foreach($whiteList as $entry){
            if($mime==$entry){
                $validate=true;
                break;
            }
        }

        return $validate;
    }

    /**
     * Compares file extension with filter set
     *
     * @param string $validationSet
     * @return bool
     */
    private function _fileEndingCheck($validationSet){
        $validate=false;
        $whiteList=Validation::$fileEnding[$validationSet];

        $ext = pathinfo($this->file, PATHINFO_EXTENSION);

        foreach($whiteList as $entry){
            if($ext==$entry){
                $validate=true;
                break;
            }
        }

        return $validate;
    }

    /**
     * Defines several set of allowed file endings depending on filter
     * @var array
     */
    private static $fileEnding=array(
        "image"=>array(".jpeg",".jpg",".png",".gif"),
    );

    /**
     * Defines several set of allowed mime types depending on filter
     * @var array
     */
    private static $mime=array(
        "image"=>array("image/jpeg","image/png","image/gif"),
    );
}
