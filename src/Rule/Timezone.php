<?php
/**
 * inetprocess/transformation
 *
 * PHP Version 5.3
 *
 * @author Emmanuel Dyan
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
 * Transforms a Date format to another
 */
class Timezone extends AbstractRule
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
    public function transform($input, array $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) !== 2 && count($arguments) !== 3) {
            throw new TransformationException('Rule Timezone Expects 2 or 3 arguments');
        }

        // Validate the date with the format provided
        $timezone = (array_key_exists(2, $arguments) ? $arguments[2] : date_default_timezone_get());
        $dateTime = \DateTime::createFromFormat($arguments[0], $input, new \DateTimeZone($timezone));
        if ($dateTime === false) {
            throw new TransformationException("Input ($input) or format ({$arguments[0]}) is not valid");
        }

        // Change the TimeZone
        try {
            $dateTime->setTimezone(new \DateTimeZone($arguments[1]));
        } catch (\Exception $e) {
            throw new TransformationException("Timezone '{$arguments[1]}' is not valid");
        }

        $output = $dateTime->format($arguments[0]);

        return $output;
    }
}
