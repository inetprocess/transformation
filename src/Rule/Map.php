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
        // I should have two arguments: old format / new format
        if (count($arguments) !== 1) {
            throw new TransformationException(
                'Rule Map expects exactly 1 argument'
            );
        }
        $mapping = $arguments[0];
        if (!is_array($mapping)) {
            throw new TransformationException(
                'First argument of Map should be an assosiative array'
            );
        }
        $this->mapping = $mapping;

        if (!is_array($input)) {
            return $this->replace($input);
        }
        return array_map(array($this, 'replace'), $input);
    }

    /**
     * @param string $value
     */
    public function replace($value)
    {
        // If not array map and return fast
        if (array_key_exists($value, $this->mapping)) {
            return $this->mapping[$value];
        }
        // Couldn't map so return as is
        return $value;
    }
}
