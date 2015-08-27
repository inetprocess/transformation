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

namespace Inet\Transformation\Exception;

/**
 * Transformation exceptions.
 */
class InvalidRuleException extends \RuntimeException
{
    /**
     * Set a default message
     * @var    string
     */
    protected $message = 'That Transformation rule does not exist';
}
