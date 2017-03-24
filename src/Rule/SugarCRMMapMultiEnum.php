<?php
/**
 * inetprocess/transformation
 *
 * PHP Version 5.3
 *
 * @author Rémi Sauvat
 * @copyright 2005-2015 iNet Process
 *
 * @package inetprocess/transformation
 *
 * @license GNU General Public License v2.0
 *
 * @link http://www.inetprocess.com
 */

namespace Inet\Transformation\Rule;

use Inet\Transformation\Exception\TransformationException;

/**
 * Call a function and send back the result
 */
class SugarCRMMapMultiEnum extends AbstractRule
{
    /**
     * Operate the transformation
     *
     * @param string $input
     * @param array  $arguments
     *
     * @throws Inet\Transformation\Exception\TransformationException
     *
     * @return string
     */
    public function transform($input, $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) !== 1 and count($arguments) !== 2) {
            throw new TransformationException(
                'Rule SugarCRMMapMultiEnum expects 1 or 2 argument: mapping, options'
            );
        }
        $mapping = $arguments[0];
        if (!is_array($mapping)) {
            throw new TransformationException(
                'First argument of SugarCRMMapMultiEnum should by an assosiative array'
            );
        }
        // Merge options with defaults
        $options = array(
            'separator' => '|',
            'from_multi_enum' => false,
        );
        if (!empty($arguments[1])) {
            $opts = $arguments[1];
            if (!is_array($opts)) {
                throw new TransformationException(
                    'Optionnal second argument of SugarCRMMapMultiEnum should by an associative array'
                );
            }
            foreach ($options as $key => $value) {
                if (array_key_exists($key, $opts)) {
                    $options[$key] = $opts[$key];
                }
            }
        }

        if ($options['from_multi_enum']) {
            // Decode multiEnum value
            $input = $this->unencodeMultienum($input);
        }

        if (!is_array($input)) {
            $input = explode($options['separator'], $input);
        }
        $ret = array();
        foreach ($input as $value) {
            if (array_key_exists($value, $mapping)) {
                $value = $mapping[$value];
            }
            if (!empty($value)) {
                $ret[] = $value;
            }
        }
        return $this->encodeMultienumValue($ret);
    }

    /**
     * Function copied from SugarCRM
     */
    public function unencodeMultienum($string)
    {
        if (is_array($string)) {
            return $string;
        }
        if (substr($string, 0, 1) == "^" && substr($string, -1) == "^") {
            // Remove empty values from beginning and end of the string
            $string = preg_replace('/^(\^\^,\^)|(\^,\^\^)$/', '^', $string);

            // Get the inner part of the string without leading|trailing ^ chars
            $string = substr(substr($string, 1), 0, strlen($string) -2);
        }

        return explode('^,^', $string);
    }

    public function encodeMultienumValue($arr)
    {
        if (empty($arr)) {
            return "";
        }

        $string = "^" . implode('^,^', $arr) . "^";

        return $string;
    }
}
