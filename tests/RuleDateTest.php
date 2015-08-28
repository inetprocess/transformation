<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleDateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Date Expects exactly 2 arguments|
     */
    public function testDateNoParameters()
    {
        T::Date()->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Date Expects exactly 2 arguments|
     */
    public function testDateOneParameters()
    {
        T::Date('Y-m-d')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float and bool are transformable|
     */
    public function testDateTwoParametersDateNull()
    {
        T::Date('Y-m-d', 'd-m-Y')->transform(null);
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Input \(foo\) or format \(Y-m-d\) is not valid|
     */
    public function testDateWrongDate()
    {
        T::Date('Y-m-d', 'd-m-Y')->transform('foo');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Output format seems not valid. Returned date is empty|
     */
    public function testDateWrongFormat()
    {
        $output = T::Date('Y-m-d', null)->transform('2015-01-01');
        $this->assertEquals($output, '01-01-2015');
    }

    public function testDateRightParameters()
    {
        $output = T::Date('Y-m-d', 'd-m-Y')->transform('2015-01-01');
        $this->assertEquals($output, '01-01-2015');
    }

    public function testDateRightParametersDoubleTransformation()
    {
        $date = '2015-01-01';
        $output = T::Date('Y-m-d', 'd-m-Y')->Date('d-m-Y', 'Y-m-d')->transform($date);
        $this->assertEquals($output, $date);
    }
}
