<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleNormalizeURLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule NormalizeURL Expects exactly 1 argument|
     */
    public function testImplodeNoParameters()
    {
        T::NormalizeURL()->transform('test.com');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule NormalizeURL Expects exactly 1 argument|
     */
    public function testImplodeTwoParameters()
    {
        T::NormalizeURL('a', 'b')->transform('test.com');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Protocol must be specified without "://"|
     */
    public function testImplodeWrongProtocol()
    {
        T::NormalizeURL('http://')->transform('test.com');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float, bool and array are transformable|
     */
    public function testNormalizeURLTwoParametersNormalizeURLNull()
    {
        T::NormalizeURL('http')->transform(new \StdClass);
    }

    public function testNormalizeURLRightParametersNoChange()
    {
        $urls = array('', 'http://', 'http://www.example.com', 'https://www.example.com', 'https://example.com/test/');
        foreach ($urls as $url) {
            $output = T::NormalizeURL('http')->transform($url);
            $this->assertEquals($output, $url);
        }
    }

    public function testNormalizeURLRightParametersChanges()
    {
        $urls = array('www.test.com/folder/file.html', 'test.com', 'www.example.com');
        foreach ($urls as $url) {
            $output = T::NormalizeURL('http')->transform($url);
            $this->assertEquals($output, 'http://' . $url);
        }
    }
}
