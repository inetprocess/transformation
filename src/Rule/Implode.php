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

use Inet\Transformation\Exception\NotTransformableException;
use Inet\Transformation\Exception\TransformationException;

/**
 * Implode an array (useful after a callback)
 */
class Implode extends AbstractRule
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
        if (count($arguments) !== 1) {
            throw new TransformationException('Rule Implode Expects exactly 1 argument');
        }

        if (!is_array($input)) {
            throw new NotTransformableException('Rule Implode can transform an array. '
                . gettype($input) . ' found in input');
        }

        // Transform it
        $output = implode($arguments[0], $input);

        return $output;
    }
}
