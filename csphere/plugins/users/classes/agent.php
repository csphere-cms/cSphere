<?php

/**
 * Search for browser details
 *
 * PHP Version 5
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\plugins\users\classes;

/**
 * Search for browser details
 *
 * @category  Plugins
 * @package   Users
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Agent
{
    /**
     * List of known browsers, Chrome last to not match forks as Chrome
     **/
    private static $_browsers = ['Firefox' => 'Firefox',
                                 'Trident' => 'Internet Explorer',
                                 'OPR'     => 'Opera',
                                 'Version' => 'Safari',
                                 'Chrome'  => 'Chrome'];

    /**
     * List of known systems
     **/
    private static $_systems = ['Windows NT 6.3' => 'Windows 8.1',
                                'Windows NT 6.2' => 'Windows 8',
                                'Windows NT 6.1' => 'Windows 7',
                                'Windows NT 6.0' => 'Windows Vista',
                                'Windows'        => 'Windows',
                                'Mac OS X'       => 'Mac OS X',
                                'Linux'          => 'Linux'];

    /**
     * Search for browser details
     *
     * @param string $agent User agent as a string
     *
     * @return string
     **/

    public static function browser($agent)
    {
        $result = 'Unknown';
        $all    = count(self::$_browsers);
        $web    = array_keys(self::$_browsers);

        // Run threw possible browsers
        for ($i = 0; $i < $all; $i++) {

            $search = strrpos($agent, $web[$i]);

            // Format agent data on matches
            if ($search > 0) {

                $agent = substr($agent, $search);
                $agent = explode('/', $agent)[1];
                $agent = (int)explode('.', $agent)[0];

                // Trident version plus four is very often IE version
                if ($web[$i] == 'Trident') {

                    $agent += 4;
                }

                // Add version to browser name
                $result = self::$_browsers[$web[$i]] . ' ' . $agent;

                $i = $all;
            }
        }

        return $result;
    }

    /**
     * Search for system details
     *
     * @param string $agent User agent as a string
     *
     * @return string
     **/

    public static function system($agent)
    {
        $result = 'Unknown';
        $all    = count(self::$_systems);
        $ops    = array_keys(self::$_systems);

        // Run threw possible systems
        for ($i = 0; $i < $all; $i++) {

            $search = strrpos($agent, $ops[$i]);

            // Format agent data on matches
            if ($search > 0) {

                $result = self::$_systems[$ops[$i]];

                $i = $all;
            }
        }

        return $result;
    }
}