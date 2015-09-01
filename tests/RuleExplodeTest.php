<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleExplodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Explode Expects exactly 1 argument|
     */
    public function testExplodeNoParameters()
    {
        T::Explode()->transform('abababababab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Explode Expects exactly 1 argument|
     */
    public function testExplodeTwoParameters()
    {
        T::Explode('a', 'b')->transform('ab-ab-ab-ab-ab-ab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float, bool and array are transformable|
     */
    public function testExplodeTwoParametersExplodeNull()
    {
        T::Explode('|')->transform(null);
    }

    public function testExplodeRightParameters()
    {
        $input = 'ab-ab-ab-ab-ab-ab';
        $output = T::Explode('-')->transform($input);
        $this->assertInternalType('array', $output);
        $this->assertCount(6, $output);
        $this->assertEquals(implode('-', $output), $input);
    }

    public function testExplodeRightParametersDoubleTransformation()
    {
        $str = 'ab-ab-ab-ab-ab-ab';
        $output = T::Explode('-')->Implode('-')->transform($str);
        $this->assertEquals($output, $str);
    }
}
