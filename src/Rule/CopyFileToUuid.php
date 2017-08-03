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
use Rhumsaa\Uuid\Uuid;

/**
 * Call a function and send back the result
 */
class CopyFileToUuid extends AbstractRule
{
    /**
     * Operate the transformation
     * If input is an array each cell is replaced independently
     * and an array is returned
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
        // Bypass for empty $input
        if ($input === null || $input === '') {
            return null;
        }
        // Check input
        if (count($arguments) !== 2) {
            throw new TransformationException(
                'Rule CopyFileToUuid expects exactly 2 argument'
            );
        }
        $source_root = $arguments[0];
        if (!is_string($source_root) || !is_dir($source_root)) {
            throw new TransformationException(
                'First argument of CopyFileToUuid should be a valid directory'
            );
        }
        $destination_path = $arguments[1];
        if (!is_string($destination_path) || !is_dir($destination_path)) {
            throw new TransformationException(
                'Second argument of CopyFileToUuid should be a valid directory'
            );
        }
        $file_path = $source_root.'/'.$input;
        if (!is_file($file_path)) {
            throw new NotTransformableException(
                'Input file "'.$file_path.'" not found'
            );
        }
        // Transform
        $uuid = Uuid::uuid4()->toString();
        $uuid_path = $destination_path.'/'.$uuid;
        if (!@copy($file_path, $uuid_path)) {
            $error = error_get_last();
            throw new NotTransformableException(
                'Error in copy of file "'.$file_path.'" to "'.$uuid_path.'": '.$error['message']
            );
        }
        return $uuid;
    }
}
