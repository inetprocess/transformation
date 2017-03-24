<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class TransformTest extends \PHPUnit_Framework_TestCase
{
    public function testMustNotInstanciate()
    {
        $reflection = new \ReflectionClass('\Inet\Transformation\Transform');
        $constructor = $reflection->getConstructor();
        $this->assertFalse($constructor->isPublic());
    }

    /**
     * @expectedException Inet\Transformation\Exception\InvalidRuleException
     * @expectedExceptionMessageRegExp |The rule 'foo' does not exist|
     */
    public function testInvalidRuleName()
    {
        T::foo('a');
    }

    /**
     * @expectedException Inet\Transformation\Exception\InvalidRuleException
     * @expectedExceptionMessageRegExp |The rule 'getFactory' does not exist|
     */
    public function testExistingStaticMethodAsRule()
    {
        T::getFactory();
    }

    /**
     * @expectedException Inet\Transformation\Exception\InvalidRuleException
     * @expectedExceptionMessage The rule 'InvalidRuleClass' must implement AbstractRule
     */
    public function testInvalidRuleImplementation()
    {
        require_once (__DIR__ . '/InvalidRuleClass.php');
        T::InvalidRuleClass();
    }
}
