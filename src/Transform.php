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

namespace Inet\Transformation;

use Inet\Transformation\Exception\InvalidRuleException;
use Inet\Transformation\Exception\NotTransformableException;

/**
 * Main class that calls statically any Rule
 *
 * @method static Transform Date(string $inputFormat, string $outputFormat)
 * @method static Transform Replace(string $search, string $replace)
 * @method static Transform ReplaceRegexp(string $pattern, string $replacement)
 * @method static Transform Slugify()
 * @method static Transform Timezone(string $inputFormat, string $targetTimezone, [string $currentTimezone])
 */
class Transform
{
    /**
     * Contains the factory
     * @var    Inet\Transformation\Transform
     */
    protected static $transform;

    /**
     * List of rules to execute on an input
     * @var    array
     */
    protected $currentRules = array();

    /**
     * Cache of rules
     * @var    array
     */
    protected static $rules = array();


    /**
     * Doesn't allow the class to be instanciated
     */
    protected function __construct()
    {

    }

    /**
     * Returns the factory to avoid having multiple instances of the same class
     * @return Factory
     */
    protected static function getFactory()
    {
        if (!static::$transform instanceof Transform) {
            static::$transform = new static();
        }

        return static::$transform;
    }

    /**
     * Return an Array of rules for an instance
     * @return    array
     */
    protected function getRules()
    {
        return $this->currentRules;
    }

    /**
     * Called on the first time to remove all old rules
     * @return    void
     */
    protected function cleanRules()
    {
        $this->currentRules = array();
    }

    /**
     * Add a rule to the rules registry
     * @param string $ruleName
     * @param array  $arguments
     *
     * @return    void
     */
    protected function addRule($ruleName, $arguments)
    {
        $ruleClass = "Inet\Transformation\Rule\\" . $ruleName;
        if (!class_exists($ruleClass)) {
            throw new InvalidRuleException("The rule '$ruleName' does not exist");
        }

        $this->currentRules[] = array(
            'rule' => $ruleClass,
            'arguments' => $arguments,
        );
    }

    /**
     * For the first execution, the method is called statically such as T::Replace('a', 'b')
     * Then get the factory, clean the previous rules and do a __call()
     *
     * @param string $ruleName
     * @param array  $arguments
     *
     * @return Transform
     */
    public static function __callStatic($ruleName, $arguments)
    {
        $transform = self::getFactory();
        $transform->cleanRules();

        return $transform->__call($ruleName, $arguments);
    }

    /**
     * Just add a rule in the registry when called
     * @param     string    $ruleName     Name of the rule
     * @param     array     $arguments    Arguments for the rule
     * @return    void
     */
    public function __call($ruleName, $arguments)
    {
        $this->addRule($ruleName, $arguments);

        return $this;
    }

    /**
     * Transform an input by applying rule
     * @param     string    $input    Should be a string !
     * @return    string              Transformed string
     */
    public function transform($input)
    {

        $validTypes = array('boolean', 'integer', 'double', 'string');
        $inputType = gettype($input);
        if (!in_array($inputType, $validTypes)) {
            throw new NotTransformableException;
        }

        // Apply rule by rule
        foreach ($this->getRules() as $ruleArgs) {
            // Execute the transformation
            $rule = $ruleArgs['rule'];
            $args = $ruleArgs['arguments'];

            // All instances are cached to avoid creating new one for each call
            if (!array_key_exists($rule, self::$rules)) {
                self::$rules[$rule] = new $rule;
            }
            // More readable variable
            $input = self::$rules[$rule]->transform($input, $args);
        }

        return $input;
    }
}
