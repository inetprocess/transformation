<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleHtmlspecialcharsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule Htmlspecialchars expects at most 3 arguments
     */
    public function testTooManyParameters()
    {
        T::Htmlspecialchars('foo', 'bar', 'test', 'baz')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of Htmlspecialchars should be an array
     */
    public function testNotArrayHtmlspecialcharsping()
    {
        T::Htmlspecialchars('strtoupper')->transform('test');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Flags should be valid PHP constants
     */
    public function testInvalidConstant()
    {
        T::Htmlspecialchars(array('FOO_BAR'))->transform('foo');
    }

    public function validTestProvider()
    {
        return array(
            // Test case 1
            array('&#039;', "'", array(array('ENT_QUOTES'))),
            // Test case 2
            array("&quot;'", '"\'', array()),
            array('&#039;', '&#039;', array(null, null, false)),
        );
    }

    /**
     * @dataProvider validTestProvider
     */
    public function testValid($expected, $input, $options)
    {
        $transform = call_user_func_array('Inet\Transformation\Transform::Htmlspecialchars', $options);
        $output = $transform->transform($input);
        $this->assertEquals($expected, $output);
    }
}
