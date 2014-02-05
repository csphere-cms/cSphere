<?php

/**
 * Provides view functionality
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   View
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\view;

/**
 * Provides view functionality
 *
 * @category  Core
 * @package   View
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Base extends \csphere\core\service\Drivers
{
    /**
     * Stores the content parts
     **/
    protected $content = [];

    /**
     * Content type header
     **/
    protected $type = '';

    /**
     * Allows for adding content
     *
     * @param string $content The content that should be attached
     *
     * @return boolean
     **/

    public function add($content)
    {
        // Add string to content
        $this->content[] = $content;

        return true;
    }

    /**
     * Put everything together
     *
     * @param boolean $xhr Defaults to false which turns xhr mode off
     * @param boolean $box Defaults to false which turns box mode off
     *
     * @return string
     **/

    public final function assemble($xhr = false, $box = false)
    {
        // Check for json object requests
        if ($xhr == 1) {

            $type = 'application/json; charset=UTF-8';

            $array = $this->format($box);

            $output = json_encode($array, JSON_FORCE_OBJECT);

        } else {

            $type = $this->type;

            $output = $this->combine($box);
        }

        // Set content type header
        \csphere\core\http\Response::header('Content-Type', $type);

        return $output;
    }

    /**
     * Combine content parts on usual requests
     *
     * @param boolean $box Special case for box mode
     *
     * @return string
     **/

    abstract protected function combine($box);

    /**
     * Format content parts on json requests
     *
     * @param boolean $box Special case for box mode
     *
     * @return array
     **/

    protected function format($box)
    {
        // Just use combine method as content by default
        $result            = [];
        $result['content'] = $this->combine($box);

        return $result;
    }

    /**
     * Check for view settings like e.g. debug
     *
     * @param string $key Get a specific array key
     *
     * @return mixed
     **/

    public function getOption($key)
    {
        // Check if the key exists
        if (isset($this->config[$key])) {

            return $this->config[$key];
        } else {

            return null;
        }
    }
}