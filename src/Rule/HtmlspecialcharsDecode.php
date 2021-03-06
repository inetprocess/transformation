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
class HtmlspecialcharsDecode extends AbstractRule
{
    public function transform($input, array $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) > 1) {
            throw new TransformationException(
                'Rule HtmlspecialcharsDecode expects at most 1 argument'
            );
        }
        if (isset($arguments[0])) {
            $flags_array = $arguments[0];
            $arguments[0] = 0;
            if (!is_array($flags_array)) {
                throw new TransformationException(
                    'First argument of HtmlspecialcharsDecode should be an array'
                );
            }
            foreach ($flags_array as $constant) {
                if (!defined($constant)) {
                    throw new TransformationException(
                        'Flags should be valid PHP constants'
                    );
                }
                $arguments[0] |= constant($constant);
            }
        } else {
            $arguments[0] = ENT_COMPAT | (defined('ENT_HTML401') ? ENT_HTML401 : 0);
        }
        return htmlspecialchars_decode($input, $arguments[0]);
    }
}
