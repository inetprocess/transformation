<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleSetTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule SetType expects exactly 1 argument
     */
    public function testNoParameters()
    {
        T::SetType()->transform('list');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule SetType expects exactly 1 argument
     */
    public function testTooManyParameters()
    {
        T::SetType('foo', 'bar')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of SetType should be a string
     */
    public function testNotStringParam()
    {
        T::SetType(array('test'))->transform('test');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule SetType Error: input from "array" to "invalid"
     */
    public function testSetTypeError()
    {
        T::SetType('invalid')->transform(array('test'));
    }

    public function validTestProvider()
    {
        return array(
            // Test case 1
            array('key1', 'key1', 'string'),
            // Test case 2
            array(true, '20', 'bool'),
            array(20.3, '20.3', 'float'),
            array(array('key1'), 'key1', 'array'),
        );
    }

    /**
     * @dataProvider validTestProvider
     */
    public function testValid($expected, $input, $type)
    {
        $output = T::SetType($type)->transform($input);
        $this->assertEquals($expected, $output);
    }
}
