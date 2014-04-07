<?php

/**
 * Provides view functionality as a mock-up
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
 * Provides view functionality as a mock-up
 *
 * @category  Core
 * @package   View
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_None extends Base
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

        return '';
    }
}
