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
class Map extends AbstractRule
{
    protected $mapping = array();
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
            throw new TransformationException(
                'Rule Map expects exactly 1 argument'
            );
        }
        $mapping = $arguments[0];
        if (!is_array($mapping)) {
            throw new TransformationException(
                'First argument of Map should by an assosiative array'
            );
        }
        $this->mapping = $mapping;

        if (!is_array($input)) {
            return $this->map($input);
        }
        // More complex version if input is an array
        // Map each cell independently
        // And return an array
        return array_map(array($this, 'map'), $input);
    }

    public function map($value)
    {
        // If not array map and return fast
        if (array_key_exists($value, $this->mapping)) {
            return $this->mapping[$value];
        }
        // Couldn't map so return as is
        return $value;
    }
}
