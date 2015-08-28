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
 * Replace a string with a Regexp
 */
class ReplaceRegexp extends AbstractRule
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
            throw new TransformationException('Rule ReplaceRegexp Expects exactly 2 arguments');
        }

        $output = @preg_replace($arguments[0], $arguments[1], $input);
        // Validate the regexp was OK
        if (is_null($output)) {
            $msg = 'ReplaceRegexp was not able to transform your string. Check your expressions';
            throw new TransformationException($msg);
        }

        return $output;
    }
}
