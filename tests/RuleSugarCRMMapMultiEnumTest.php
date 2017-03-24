<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleSugarCRMMapMultiEnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule SugarCRMMapMultiEnum expects 1 or 2 argument: mapping, options
     */
    public function testNoParameters()
    {
        T::SugarCRMMapMultiEnum()->transform('list');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule SugarCRMMapMultiEnum expects 1 or 2 argument: mapping, options
     */
    public function testTooManyParameters()
    {
        T::SugarCRMMapMultiEnum('foo', 'bar', 'baz')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of SugarCRMMapMultiEnum should by an assosiative array
     */
    public function testNotArrayMapping()
    {
        T::SugarCRMMapMultiEnum('strtoupper')->transform('test');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Optionnal second argument of SugarCRMMapMultiEnum should by an associative array
     */
    public function testNotArrayOptions()
    {
        T::SugarCRMMapMultiEnum(array('test'), 'test')->transform('test');
    }


    public function validTestProvider()
    {
        $mapping = array(
            '1' => 'key1',
            '10' => 'key10',
        );
        return array(
            // Test case 1
            array('^key1^', '1', $mapping, array()),
            // Test case 2
            array('^20^', '20', $mapping, array()),
            array('^key1^,^2^,^key10^', '1|2|10', $mapping, array()),
            array('^key1^,^2^,^key10^', '^1^,^2^,^10^', $mapping, array('from_multi_enum' => true)),
            array('^key1^,^2^,^key10^', '^^,^1^,^2^,^10^', $mapping, array('from_multi_enum' => true)),
            array('', '', $mapping, array()),
            array('^key1^', array('1', ''), $mapping, array()),
            array('^key1^', array('1', ''), $mapping, array('from_multi_enum' => true)),
        );
    }

    /**
     * @dataProvider validTestProvider
     */
    public function testValid($expected, $input, $mapping, $options)
    {
        $output = T::SugarCRMMapMultiEnum($mapping, $options)->transform($input);
        $this->assertEquals($expected, $output);
    }
}
