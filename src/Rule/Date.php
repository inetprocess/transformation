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
class Date extends AbstractRule
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
        if (count($arguments) !== 2) {
            throw new TransformationException('Rule Date Expects exactly 2 arguments');
        }

        // Validate the date with the format provided
        $dateTime = \DateTime::createFromFormat($arguments[0], $input);
        if ($dateTime === false) {
            throw new TransformationException("Input ($input) or format ({$arguments[0]}) is not valid");
        }

        // Transform it
        $output = $dateTime->format($arguments[1]);
        if (strlen($output) === 0) {
            throw new TransformationException('Output format seems not valid. Returned date is empty');
        }

        return $output;
    }
}
