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
 * Call a function and send back the result
 */
class Callback extends AbstractRule
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
        if (count($arguments) === 0) {
            throw new TransformationException('Rule Callback Expects at least 1 argument');
        }

        $callable = $arguments[0];

        unset($arguments[0]);
        // Functions is callable ?
        if (!is_callable($callable)) {
            throw new TransformationException($callable.' is not callable');
        }

        // Transform it by calling the method and sending arguments
        // Process remaining arguments
        $args = array();
        if (count($arguments) > 0) {
            foreach ($arguments as $argument) {
                $args[] = $argument;
            }
        }
        // Inject the $input as the latest argument
        $args[] = $input;
        $output = call_user_func_array($callable, $args);

        return $output;
    }
}
