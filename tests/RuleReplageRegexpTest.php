<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleReplageRegexpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule ReplaceRegexp Expects exactly 2 arguments|
     */
    public function testReplaceRegexpNoParameters()
    {
        T::ReplaceRegexp()->transform('abababababab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule ReplaceRegexp Expects exactly 2 arguments|
     */
    public function testReplaceRegexpOneParameters()
    {
        T::ReplaceRegexp('/a/i')->transform('abababababab');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float and bool are transformable|
     */
    public function testReplaceRegexpTwoParametersReplaceRegexpNull()
    {
        T::ReplaceRegexp('/a/i', 'b')->transform(null);
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |ReplaceRegexp was not able to transform your string: .*|
     */
    public function testReplaceRegexpWrongRegexp()
    {
        T::ReplaceRegexp('/ai', 'b')->transform('abababababa');
    }

    public function testReplaceRegexpRightParameters()
    {
        $output = T::ReplaceRegexp('/a/', 'b')->transform('abababababab');
        $this->assertEquals($output, preg_replace('/a/', 'b', 'abababababab'));
    }

    public function testReplaceRegexpRightParametersDoubleTransformation()
    {
        $str = 'ABABABABABAB';
        $output = T::ReplaceRegexp('/a/i', 'b')->ReplaceRegexp('/b/i', 'a')->transform($str);
        $this->assertEquals($output, preg_replace('/a|b/i', 'a', $str));
    }
}
