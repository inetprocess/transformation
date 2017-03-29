<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule Map expects exactly 1 argument
     */
    public function testNoParameters()
    {
        T::Map()->transform('list');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule Map expects exactly 1 argument
     */
    public function testTooManyParameters()
    {
        T::Map('foo', 'bar')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of Map should be an assosiative array
     */
    public function testNotArrayMapping()
    {
        T::Map('strtoupper')->transform('test');
    }

    public function validTestProvider()
    {
        $mapping = array(
            '1' => 'key1',
            '10' => 'key10',
        );
        return array(
            // Test case 1
            array('key1', '1', $mapping),
            // Test case 2
            array('20', '20', $mapping),
            array('', '', $mapping),
            array(array('key1', ''), array('1', ''), $mapping),
            array('test', 'test', array()),
        );
    }

    /**
     * @dataProvider validTestProvider
     */
    public function testValid($expected, $input, $mapping)
    {
        $output = T::Map($mapping)->transform($input);
        $this->assertEquals($expected, $output);
    }
}
