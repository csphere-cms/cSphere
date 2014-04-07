<?php

/**
 * Provides mail functionality as a mock-up
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Mail
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\mail;

/**
 * Provides mail functionality as a mock-up
 *
 * @category  Core
 * @package   Mail
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Driver_None extends Base
{
    /**
     * Sends the prepared content to a given email
     *
     * @param string  $email Email target
     * @param boolean $clear Defaults to true which keeps mail data
     *
     * @return boolean
     **/

    public function send($email, $clear = true)
    {
        // Log mail and handle clear status
        $this->log($email, false);

        $this->clear($clear);

        return true;
    }
}
