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
class Htmlspecialchars extends AbstractRule
{
    public function transform($input, $arguments)
    {
        // I should have two arguments: old format / new format
        if (count($arguments) > 3) {
            throw new TransformationException(
                'Rule Htmlspecialchars expects at most 3 arguments'
            );
        }
        $defaults = array(
            ENT_COMPAT | ENT_HTML401,
            ini_get('default_charset'),
            true
        );
        if (isset($arguments[0])) {
            $flags_array = $arguments[0];
            $arguments[0] = 0;
            if (!is_array($flags_array)) {
                throw new TransformationException(
                    'First argument of Htmlspecialchars should be an array'
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
        }

        $options = $arguments + $defaults;
        return htmlspecialchars($input, $options[0], $options[1], $options[2]);
    }
}
