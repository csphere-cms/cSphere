<?php

/**
 * Collects the important data from all themes for a central registry
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
 * Collects the important data from all themes for a central registry
 *
 * @category  Core
 * @package   Themes
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

class Metadata extends \csphere\core\xml\Metadata
{
    /**
     * Type of registry
     **/
    protected $driver = 'theme';
}