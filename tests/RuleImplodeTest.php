<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleImplodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Implode Expects exactly 1 argument|
     */
    public function testImplodeNoParameters()
    {
        T::Implode()->transform('abababababab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Implode Expects exactly 1 argument|
     */
    public function testImplodeTwoParameters()
    {
        T::Implode('a', 'b')->transform('ab-ab-ab-ab-ab-ab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float, bool and array are transformable|
     */
    public function testImplodeTwoParametersImplodeNull()
    {
        T::Implode('|')->transform(null);
    }

    public function testImplodeRightParameters()
    {
        $input = array('ab', 'ab', 'ab', 'ab', 'ab', 'ab');
        $output = T::Implode('-')->transform($input);
        $this->assertInternalType('string', $output);
        $this->assertEquals(explode('-', $output), $input);
    }

    public function testImplodeRightParametersDoubleTransformation()
    {
        $input = array('ab', 'ab', 'ab', 'ab', 'ab', 'ab');
        $output = T::Implode('-')->Explode('-')->transform($input);
        $this->assertEquals($output, $input);
    }
}
