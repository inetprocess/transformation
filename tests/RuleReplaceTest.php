<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleReplaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Replace Expects exactly 2 arguments|
     */
    public function testReplaceNoParameters()
    {
        T::Replace()->transform('abababababab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Replace Expects exactly 2 arguments|
     */
    public function testReplaceOneParameters()
    {
        T::Replace('a')->transform('abababababab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float and bool are transformable|
     */
    public function testReplaceTwoParametersReplaceNull()
    {
        T::Replace('a', 'b')->transform(null);
    }

    public function testReplaceRightParameters()
    {
        $output = T::Replace('a', 'b')->transform('abababababab');
        $this->assertEquals($output, str_replace('a', 'b', 'abababababab'));
    }

    public function testReplaceRightParametersDoubleTransformation()
    {
        $str = 'abababababab';
        $output = T::Replace('a', 'b')->Replace('b', 'a')->transform($str);
        $this->assertEquals($output, str_replace('b', 'a', $str));
    }
}
