<?php

/**
 * Transforms xml and xsd to target htm file
 *
 * PHP Version 5
 *
 * @category  Tools
 * @package   XML
 * @author    Hans-Joachim Piepereit <contact@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

/**
 * Transforms xml and xsd to target htm file
 *
 * @param string $xml_file XML File
 * @param string $xsl_file XSL File
 * @param string $dir      Directory of XML and XSL file
 * @param string $target   Target directory for output file
 *
 * @return boolean
 **/

function transform ($xml_file, $xsl_file, $dir, $target)
{
    $result = false;

    $xml = new \DOMDocument;
    $xml->load($xml_file);

    $xsl = new \DOMDocument;
    $xsl->load($xsl_file);

    $proc = new \XSLTProcessor;
    $proc->importStyleSheet($xsl);

    $content = $proc->transformToXML($xml);

    if (is_writeable($dir)) {

        $save = fopen($dir . '/' . $target, 'w');
        fwrite($save, $content);
        fclose($save);
        $result = true;

    } else {

        echo 'cSphere Error: Target dir not writeable';
    }

    return $result;
}

// Check for argv to contain xml, xsl and target htm parameters
if (!isset($argv[4]) || isset($argv[5])) {

    echo 'Error: Please specify 4 params: xml, xsl, dir, file';

} elseif (transform($argv[1], $argv[2], $argv[3], $argv[4])) {

    echo 'Transformation finished with success';
}
