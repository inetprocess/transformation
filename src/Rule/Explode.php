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
 * Explode a string to an array (useful after a callback)
 */
class Explode extends AbstractRule
{
    /**
     * Operate the transformation
     *
     * @param string $input
     * @param array  $arguments
     *
     * @throws Inet\Transformation\Exception\TransformationException
     *
     * @return array
     */
    public function transform($input, array $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) !== 1) {
            throw new TransformationException('Rule Explode Expects exactly 1 argument');
        }

        // Transform it
        $output = explode($arguments[0], $input);

        return $output;
    }
}
