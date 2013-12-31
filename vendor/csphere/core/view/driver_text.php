<?php

/**
 * Provides view functionality for text files
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
 * Provides view functionality for text files
 *
 * @category  Core
 * @package   View
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_Text extends Base
{
    /**
     * Content type header
     **/
    protected $type = 'text/plain; charset=UTF-8';

    /**
     * Combine content parts on usual requests
     *
     * @param boolean $box Special case for box mode
     *
     * @return string
     **/

    protected function combine($box)
    {
        unset($box);

        $output = '';

        foreach ($this->content AS $part) {

            $output .= $part . "\n";
        }

        return $output;
    }
}