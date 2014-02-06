<?php

/**
 * Working with files
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Files
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\files;

/**
 * Working with files
 *
 * @category  Core
 * @package   Files
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class File
{
    /**
     * Content of a directory as an array
     *
     * @param string  $path   Target directory with full path
     * @param boolean $desc   Whether to list files in descending order
     * @param array   $remove List of files to remove
     *
     * @return array
     **/

    public static function search($path, $desc = false, array $remove = [])
    {
        // Directories should always end with a slash
        $dir = rtrim($path, '\/') . '/';

        // If it is not a directory use an empty array
        $scandir = is_dir($dir) ? scandir($dir) : [];

        $scandir = array_flip($scandir);

        // Remove given entries
        unset($scandir['.'], $scandir['..'], $scandir['.DS_Store']);

        foreach ($remove AS $name) {

            unset($scandir[$name]);
        }

        // Reverse order if requested
        if ($desc == true) {

            krsort($scandir);
        }

        $scandir = array_keys($scandir);

        return $scandir;
    }

    /**
     * Size of a file as a readable string number from Byte to TiB
     *
     * @param int     $size  Size of file in Bytes
     * @param int     $float Digits after the dot in resulting float
     * @param boolean $short Defaults to true which shortens high values
     *
     * @return string
     **/

    public static function size($size, $float = 3, $short = true)
    {
        // Appended to the reduced float to make it more readable
        $size_names = ['Byte', 'KiB', 'MiB', 'GiB', 'TiB'];

        $digits = 0;

        // Determine the best size name
        while ($size >= 1024 && $digits < 4) {

            $size = $size / 1024;

            $digits++;
        }

        // Size above 100 should not be a float
        if (!empty($short) && $size > 100) {

            $result = round($size);
        } else {

            $result = round($size, $float);
        }

        return $result . ' ' . $size_names[$digits];
    }

    /**
     * Mimetype of a file or buffer
     *
     * @param string  $content File with path or string variable
     * @param boolean $buffer  Use string instead of a file
     *
     * @return string
     **/

    public static function type($content, $buffer = false)
    {
        return self::_info($content, $buffer, FILEINFO_MIME_TYPE);
    }

    /**
     * Encoding of a file or buffer
     *
     * @param string  $content File with path or string variable
     * @param boolean $buffer  Use string instead of a file
     *
     * @return string
     **/

    public static function encoding($content, $buffer = false)
    {
        return self::_info($content, $buffer, FILEINFO_MIME_ENCODING);
    }

    /**
     * Mime info of a file or buffer
     *
     * @param string  $content File with path or string variable
     * @param boolean $buffer  Use string instead of a file
     * @param integer $option  Fileinfo constant
     *
     * @return string
     **/

    private static function _info($content, $buffer, $option)
    {
        // Use fileinfo extension for this
        $flp = finfo_open($option);

        if ($buffer === false) {

            $return = finfo_file($flp, $content);

        } else {

            $return = finfo_buffer($flp, $content);
        }

        finfo_close($flp);

        return $return;
    }
}