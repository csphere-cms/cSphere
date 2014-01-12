<?php

/**
 * Contains some tools to work with performance timing
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Date
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\date;

/**
 * Class for microtime operations
 *
 * @category  Core
 * @package   Date
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Microtime
{

    /**
     * Microtime comparison
     *
     * @param float $mt_start Microtime start point
     * @param float $mt_end   Microtime end point
     *
     * @return int
     **/

    public static function compare($mt_start, $mt_end)
    {
        $parsetime = round(($mt_end - $mt_start) * 1000);

        return (int)$parsetime;
    }

    /**
     * Parsetime calculation
     *
     * @param float $microtime Microtime
     *
     * @return int
     **/

    public static function untilNow($microtime)
    {
        $mt_now = microtime(true);

        return self::compare($microtime, $mt_now);
    }
}