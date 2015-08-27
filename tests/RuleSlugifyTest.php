<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;

class RuleSlugifyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessageRegExp |Rule Slugify Expects no parameter|
     */
    public function testSlugifyOneParameters()
    {
        T::Slugify('Y-m-d')->transform('Bonjour tôôut le monde !');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegExp |Only strings, int, float and bool are transformable|
     */
    public function testSlugifyTwoParametersSlugifyNull()
    {
        T::Slugify()->transform(array());
    }

    public function testSlugifyRightParameters()
    {
        $output = T::Slugify()->transform('Bonjour tôôut le monde !');
        $this->assertEquals($output, 'bonjour-toout-le-monde');
    }


    public function testSlugifyRightParametersDoubleTransformation()
    {
        $output = T::Slugify()->Replace('o', 'a')->transform('Bonjour tôôut le monde !');
        $this->assertEquals($output, str_replace('o', 'a', 'bonjour-toout-le-monde'));
    }

}
