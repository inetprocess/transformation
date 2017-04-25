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
     * PHP Constants that says what's happened with the PregRegexp
     *
     * @var array
     */
    protected $pregErrs = array(
        \PREG_INTERNAL_ERROR        => 'Internal Error',
        \PREG_BACKTRACK_LIMIT_ERROR => 'Backtrack limit',
        \PREG_RECURSION_LIMIT_ERROR => 'Recursion limit',
        \PREG_BAD_UTF8_ERROR        => 'Bad UTF-8',
        \PREG_BAD_UTF8_OFFSET_ERROR => 'Bad UTF-8 Offset'
    );

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
        if (count($arguments) !== 2) {
            throw new TransformationException('Rule ReplaceRegexp Expects exactly 2 arguments');
        }

        // Validate That the regexp was OK
        $output = preg_replace($arguments[0], $arguments[1], $input);
        if (is_null($output)) {
            $pregErr = preg_last_error();
            $pregMsg = array_key_exists($pregErr, $this->pregErrs) ? $this->pregErrs[$pregErr] : 'Unknown error';
            $msg = 'ReplaceRegexp was not able to transform your string: '.$pregMsg;
            throw new TransformationException($msg);
        }

        return $output;
    }
}
