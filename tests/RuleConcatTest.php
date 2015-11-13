<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleConcatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Concat Expects 1 or 2 argument\(s\)|
     */
    public function testImplodeNoParameters()
    {
        T::Concat()->transform('test.com');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Concat Expects 1 or 2 argument\(s\)|
     */
    public function testImplodeTwoParameters()
    {
        T::Concat('a', 'b', 'c')->transform('test.com');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float, bool and array are transformable|
     */
    public function testConcatTwoParametersConcatNull()
    {
        T::Concat('http://', '/')->transform(new \StdClass);
    }

    public function testConcat1RightParametersNoChange()
    {
        $url = 'www.google.fr';
        $before = 'http://';
        $output = T::Concat($before)->transform($url);
        $this->assertEquals($before.$url, $output);
    }

    public function testConcat2RightParametersNoChange()
    {
        $url = 'www.google.fr';
        $before = 'http://';
        $after = '/';
        $output = T::Concat($before, $after)->transform($url);
        $this->assertEquals($before.$url.$after, $output);
    }
}
