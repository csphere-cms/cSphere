<?php

/**
 * Contains some tools to work with unixtimes
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

class Unixtime
{
    /**
     * Creates a DateTimeZone object with the users timezone setting
     *
     * @return \DateTimeZone
     **/

    public static function userTimeZone()
    {
        static $timezone = null;

        if ($timezone === null) {

            // @TODO: Get time zone of user
            $user_zone = 'Europe/Berlin';

            // Test if the user has a valid timezone and use German otherwise
            $timezones = \DateTimeZone::listIdentifiers();

            if (in_array($user_zone, $timezones)) {

                $timezone = new \DateTimeZone($user_zone);
            } else {

                $timezone = new \DateTimeZone('UTC');
            }
        }

        return $timezone;
    }

    /**
     * Looks for the timezone difference in seconds
     *
     * @param int $unix Unixtime
     *
     * @return int
     **/

    public static function userOffset($unix)
    {
        $core_zone = new \DateTimeZone('UTC');
        $user_zone = self::userTimeZone();

        // Create date object to work with
        $date = \DateTime::createFromFormat('U', $unix, $core_zone);

        return $user_zone->getOffset($date);

    }

    /**
     * Translates a UTC+0 time to the user time
     *
     * @param int $unix Unixtime
     *
     * @return \DateTime
     **/

    public static function userDateTime($unix)
    {
        if ($unix < 0) {

            $unix = time();
        }

        $core_zone = new \DateTimeZone('UTC');
        $user_zone = self::userTimeZone();

        // Create date object to work with
        $date = \DateTime::createFromFormat('U', $unix, $core_zone);

        $date->setTimezone($user_zone);

        return $date;
    }
}