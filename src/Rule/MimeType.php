<?php
/**
 * inetprocess/transformation
 *
 * php version 5.3
 *
 * @author rémi sauvat
 * @copyright 2005-2015 inet process
 *
 * @package inetprocess/transformation
 *
 * @license gnu general public license v2.0
 *
 * @link http://www.inetprocess.com
 */

namespace Inet\Transformation\Rule;

use Inet\Transformation\Exception\TransformationException;
use Inet\Transformation\Exception\NotTransformableException;

/**
 * Call a function and send back the result
 */
class MimeType extends AbstractRule
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
    public function transform($input, array $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) > 1) {
            throw new TransformationException(
                'Rule MimeType expects at most 1 argument'
            );
        }
        $file_path = $input;
        if (isset($arguments[0])) {
            if (!is_string($arguments[0]) || !is_dir($arguments[0])) {
                throw new TransformationException(
                    'First argument of MimeType should be a valid directory'
                );
            }
            $file_path = $arguments[0].'/'.$input;
        }
        if (!is_file($file_path) || !is_readable($file_path)) {
            throw new NotTransformableException(
                'Input file "'.$file_path.'" not found'
            );
        }
        return @mime_content_type($file_path);
    }
}
