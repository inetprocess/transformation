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
 * Normalize a URL by adding http:// in front if it doesn't exist
 */
class NormalizeURL extends AbstractRule
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
        if (count($arguments) !== 1) {
            throw new TransformationException('Rule NormalizeURL Expects exactly 1 argument');
        }
        $protocol = $arguments[0];

        if (strpos($protocol, '://')) {
            throw new TransformationException('Protocol must be specified without "://"');
        }

        // Transform it
        $pattern = '|^(?!'.$protocol.')(.+)$|';
        preg_match($pattern, $input, $matches);
        if (!empty($matches)) {
            $input = $protocol.'://'.$input;
        }

        return $input;
    }
}
