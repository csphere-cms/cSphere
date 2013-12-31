<?php

/**
 * Contains some tools to check themes with
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Themes
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\themes;

/**
 * Contains some tools to check themes with
 *
 * @category  Core
 * @package   Themes
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Checks
{
    /**
     * Theme that will be used
     **/
    private $_theme = '';

    /**
     * Local path
     **/
    private $_path = '';

    /**
     * File that will be used
     **/
    private $_file = '';

    /**
     * Remember positive existance checks
     **/
    private $_existance = false;

    /**
     * Get theme to see if it exists
     *
     * @param string $theme Name of theme
     *
     * @return \csphere\core\themes\Checks
     **/

    public function __construct($theme)
    {
        $this->_path = \csphere\core\init\path();

        $this->_theme = $theme;

        // Check theme details
        $this->_validate();

        $this->_file = 'csphere/themes/' . $this->_theme . '/index.htm';
    }

    /**
     * Check if plugin is valid
     *
     * @throws \Exception
     *
     * @return void
    **/

    private function _validate()
    {
        $meta = new \csphere\core\themes\Metadata();

        $exists = $meta->exists($this->_theme);

        if ($exists == false) {

            $msg = 'Theme not found: "' . $this->_theme . '"';

            throw new \Exception($msg);
        }
    }

    /**
     * Checks if the target file exists
     *
     * @return boolean
     **/

    public function existance()
    {
        $result = false;

        // Check for file existance if not done already
        if ($this->_existance == true) {

            $result = true;
        } else {

            $target = $this->_path . $this->_file;

            // File must set before
            if (file_exists($target)) {

                $this->_existance = true;
                $result           = true;
            }
        }

        return $result;
    }

    /**
     * Dirname for external theme path
     *
     * @return string
     **/

    public function dirname()
    {
        $dirname = \csphere\core\http\Request::get('dirname')
                 . 'vendor/csphere/themes/' . $this->_theme . '/';

        return $dirname;
    }

    /**
     * Replies with the target file
     *
     * @param boolean $path Append local path which defaults to true
     *
     * @throws \Exception
     *
     * @return string
     **/

    public function result($path = true)
    {
        $exists = $this->existance();

        // File must be there to return its origin
        if ($exists == false) {

            throw new \Exception('Theme target not found: "' . $this->_file . '"');
        } else {

            $place = ($path == true) ? $this->_path . $this->_file :  $this->_file;
        }

        return isset($place) ? $place : '';
    }
}