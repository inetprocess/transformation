<?php
/**
 * inetprocess/transformation
 *
 * PHP Version 5.3
 *
 * @author Emmanuel Dyan
 * @copyright 2005-2015 iNet Process
 * @package inetprocess/transformation
 * @license GNU General Public License v2.0
 * @link http://www.inetprocess.com
 */

namespace Inet\Transformation\Rule;

use Inet\Transformation\Exception\TransformationException;

/**
 * Replace a string with another
 */
class Replace extends AbstractRule
{
    /**
     * Operate the transformation
     * @param     string    $input
     * @param     array     $arguments
     * @throws    Inet\Transformation\Exception\TransformationException
     * @return    string
     */
    public function transform($input, $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) !== 2) {
            throw new TransformationException('Rule Replace Expects exactly 2 arguments');
        }

        // Transform it
        $output = str_replace($arguments[0], $arguments[1], $input);

        return $output;
    }
}
