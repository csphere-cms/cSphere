<?php

/**
 * Form element creation helpers
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

namespace csphere\core\template;

/**
 * Form element creation helpers
 *
 * @category  Core
 * @package   Template
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

abstract class Form
{
    /**
     * Creates the HTML option tags for a select tag
     *
     * @param array  $data    Data with value and text keys per row
     * @param string $value   Name of the key to use for the option value
     * @param string $text    Name of the key to use for the option text
     * @param string $default Default value that should be marked as selected
     *
     * @return string
     **/

    public static function options(array $data, $value, $text, $default = '')
    {
        $result = '';

        // Add all options with value and text
        foreach ($data AS $option) {

            // Check if value is default
            $active = '';

            if ($option[$value] == $default) {

                $active = ' selected="selected"';
            }

            // HHVM does not support ENT_SUBSTITUTE and ENT_HTML5 yet
            $option[$value] = htmlspecialchars(
                $option[$value], ENT_QUOTES, 'UTF-8', false
            );

            $option[$text] = htmlspecialchars(
                $option[$text], ENT_QUOTES, 'UTF-8', false
            );

            // Build HTML string
            $result .= '<option value="' . $option[$value] . '"' . $active . '>'
                     . $option[$text]
                     . '</option>';
        }

        return $result;
    }
}