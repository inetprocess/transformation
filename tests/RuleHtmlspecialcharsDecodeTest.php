<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleHtmlspecialcharsDecodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule HtmlspecialcharsDecode expects at most 1 argument
     */
    public function testTooManyParameters()
    {
        T::HtmlspecialcharsDecode('foo', 'bar')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of HtmlspecialcharsDecode should be an array
     */
    public function testNotArrayHtmlspecialcharsDecodeping()
    {
        T::HtmlspecialcharsDecode('strtoupper')->transform('test');
    }

    public function validTestProvider()
    {
        return array(
            // Test case 1
            array('"\'', "&quot;'", array()),
            // Test case 2
            array("'", '&#039;', array(array('ENT_QUOTES'))),
        );
    }

    /**
     * @dataProvider validTestProvider
     */
    public function testValid($expected, $input, $options)
    {
        $transform = call_user_func_array('Inet\Transformation\Transform::HtmlspecialcharsDecode', $options);
        $output = $transform->transform($input);
        $this->assertEquals($expected, $output);
    }
}
