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
 * Concat strings
 */
class Concat extends AbstractRule
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
        if (count($arguments) !== 1 && count($arguments) !== 2) {
            throw new TransformationException('Rule Concat Expects 1 or 2 argument(s)');
        }
        $before = $arguments[0];
        $after = (array_key_exists(1, $arguments) ? $arguments[1] : '');

        return $before.$input.$after;
    }
}
