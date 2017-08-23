<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;
use Symfony\Component\Filesystem\Filesystem;

class RuleMimeTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule MimeType expects at most 1 argument
     */
    public function testTooManyParameters()
    {
        T::MimeType('foo', 'bar')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of MimeType should be a valid directory
     */
    public function testNotValidRootDir()
    {
        T::MimeType('unknown_dir')->transform('test');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegexp /^Input file ".*" not found$/
     */
    public function testNotValidInputFile()
    {
        T::MimeType(__DIR__)->transform('unknown_file');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegexp /^Input file ".*" not found$/
     */
    public function testEmpty()
    {
        $this->assertNull(T::MimeType(__DIR__)->transform(''));
    }

    public function testValid()
    {

        $this->assertEquals('text/plain', T::MimeType()->transform(__DIR__.'/../README.md'));
    }
}
