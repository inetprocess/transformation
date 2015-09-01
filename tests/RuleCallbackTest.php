<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleCallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Callback Expects at least 1 argument|
     */
    public function testCallbackNoParameters()
    {
        T::Callback()->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |foo is not callable|
     */
    public function testCallwrongMethod()
    {
        T::Callback('foo')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float, bool and array are transformable|
     */
    public function testCallbackTwoParametersDateNull()
    {
        T::Callback('strtoupper')->transform(null);
    }

    public function testCallbackSimpleFunction()
    {
        $output = T::Callback('strtoupper')->transform('foo');
        $this->assertEquals($output, 'FOO');
    }

    public function testCallbackClassMethod()
    {
        $date = '2015-01-01';
        $dateTime = T::Callback('DateTime::createFromFormat', 'Y-m-d')->transform($date);
        $output = $dateTime->format('d-m-Y');
        $this->assertEquals($output, '01-01-2015');
    }


    public function testCallbackSimpleFunctionMultipleArguments()
    {
        $str = 'ababab';
        $output = T::Callback('str_replace', 'a', 'b')->transform($str);
        $this->assertEquals($output, 'bbbbbb');
    }
}
