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
class SetType extends AbstractRule
{
    /**
     * Operate the transformation
     *
     * @param mixed $input
     * @param array  $arguments
     *
     * @throws Inet\Transformation\Exception\TransformationException
     *
     * @return mixed
     */
    public function transform($input, $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) !== 1) {
            throw new TransformationException(
                'Rule SetType expects exactly 1 argument'
            );
        }
        $type = $arguments[0];
        if (!is_string($type)) {
            throw new TransformationException(
                'First argument of SetType should be a string'
            );
        }
        if (@settype($input, $type) === false) {
            $err = error_get_last();
            throw new TransformationException(
                'Rule SetType Error: input from "'.gettype($input).'" to "'.$type.'"'. PHP_EOL
                . $err['message']
            );
        }
        return $input;
    }
}
