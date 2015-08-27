<?php
/**
 * inetprocess/transformation
 *
 * PHP Version 5.3
 *
 * @author Emmanuel Dyan
 * @copyright 2005-2015 iNet Process
 * @package inetprocess/transformation
 * @license GNU General Public License v2.0
 * @link http://www.inetprocess.com
 */

namespace Inet\Transformation\Rule;

/**
 * Defines how to write a Rule
 */
abstract class AbstractRule
{
    abstract public function transform($input, $arguments);
}
