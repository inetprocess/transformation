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

use Cocur\Slugify\Slugify as CocurSlugify;
use Inet\Transformation\Exception\NotTransformableException;
use Inet\Transformation\Exception\TransformationException;

/**
 * Replace a string with another
 */
class Slugify extends AbstractRule
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
        if (count($arguments) !== 0) {
            throw new TransformationException('Rule Slugify Expects no parameter');
        }

        try {
            $slugify = new CocurSlugify();
            $output = $slugify->slugify($input);
        } catch (\Exception $e) {
            throw new NotTransformableException(
                'Rule Slugify: Unable to transform input (' . var_export($input, true) . ')'
            );
        }

        return $output;
    }
}
