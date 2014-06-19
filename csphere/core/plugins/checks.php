<?php

/**
 * Contains some tools to check plugins with
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\plugins;

/**
 * Contains some tools to check plugins with
 *
 * @category  Core
 * @package   Plugins
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Checks
{
    /**
     * Plugin that will be used
     **/
    private $_plugin = '';

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
     * Get plugin to see if it exists
     *
     * @param string $plugin Name of plugin
     *
     * @return \csphere\core\plugins\Checks
     **/

    public function __construct($plugin)
    {
        $this->_path = \csphere\core\init\path();

        $this->_plugin = $plugin;

        // Check plugin details
        $this->_validate();
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
        $meta = new \csphere\core\plugins\Metadata();

        $exists = $meta->exists($this->_plugin);

        if ($exists == false) {

            $msg = 'Plugin not found: "' . $this->_plugin . '"';

            throw new \Exception($msg);
        }
    }

    /**
     * Checks if the target file exists
     *
     * @throws \Exception
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
            if (empty($this->_file)) {

                throw new \Exception('No plugin file set to check for');

            } elseif (file_exists($target)) {

                $this->_existance = true;
                $result           = true;
            }
        }

        return $result;
    }

    /**
     * Set target for requests
     *
     * @param string  $target Name of target
     * @param boolean $box    Set this to true for box only requests
     *
     * @throws \Exception
     *
     * @return void
     **/

    public function setRoute($target)
    {
        // Route should not contain other chars
        if (!preg_match("=^[_a-z0-9-]+$=i", $target)) {

            throw new \Exception('Name of plugin target contains unallowed chars');
        }

        $metadata=new metadata();
        $type=$metadata->templateType($this->_plugin,$target);

        $this->_file = 'csphere/plugins/' . $this->_plugin
                     . '/actions/' . $type. '/' . $target . '.php';

    }

    /**
     * Set target for template files
     *
     * @param string $target Name of target
     *
     * @return void
     **/

    public function setTemplate($target)
    {

        $metadata=new metadata();
        $type=$metadata->templateType($this->_plugin,$target);

        $this->_file = 'csphere/plugins/' . $this->_plugin
                     . '/templates/' . $type. '/' . $target . '.tpl';
        if(substr_count($this->_file,"box_latest.tpl")>0){
            echo'<pre>';
            debug_print_backtrace();
            die();
        }
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

            throw new \Exception('Plugin target not found: "' . $this->_file . '"');
        } else {

            $place = ($path == true) ? $this->_path . $this->_file :  $this->_file;
        }

        return isset($place) ? $place : '';
    }
}
