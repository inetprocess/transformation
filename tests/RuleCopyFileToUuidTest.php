<?php
namespace Inet\Transformation\Tests;

use Inet\Transformation\Transform as T;
use Symfony\Component\Filesystem\Filesystem;

class RuleCopyFileToUuidTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule CopyFileToUuid expects exactly 2 argument
     */
    public function testNoParameters()
    {
        T::CopyFileToUuid()->transform('list');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule CopyFileToUuid expects exactly 2 argument
     */
    public function testOneParameters()
    {
        T::CopyFileToUuid('foo')->transform('list');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Rule CopyFileToUuid expects exactly 2 argument
     */
    public function testTooManyParameters()
    {
        T::CopyFileToUuid('foo', 'bar', 'baz')->transform('2015-01-01');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage First argument of CopyFileToUuid should be a valid directory
     */
    public function testNotValidSourceDir()
    {
        T::CopyFileToUuid('unknown_dir', __DIR__)->transform('test');
    }

    /**
     * @expectedException Inet\Transformation\Exception\TransformationException
     * @expectedExceptionMessage Second argument of CopyFileToUuid should be a valid directory
     */
    public function testNotValidDestDir()
    {
        T::CopyFileToUuid(__DIR__, 'unknown_dir')->transform('test');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessageRegexp /^Input file ".*" not found$/
     */
    public function testNotValidInputFile()
    {
        T::CopyFileToUuid(__DIR__, __DIR__)->transform('unknown_file');
    }

    /**
     * @expectedException Inet\Transformation\Exception\NotTransformableException
     * @expectedExceptionMessage Error in copy of file
     */
    public function testErrorCopy()
    {
        T::CopyFileToUuid(__DIR__, '/')->transform(basename(__FILE__));
    }


    public function testEmpty()
    {
        $this->assertNull(T::CopyFileToUuid(__DIR__, __DIR__)->transform(''));
    }

    public function testValid()
    {
        $input_dir = __DIR__.'/copyuuid';
        $input_file = __DIR__.'/copyuuid/file.pdf';
        $output_dir = __DIR__.'/copyuuiddst';
        $fs = new Filesystem();
        $fs->mkdir($input_dir);
        $fs->touch($input_file);
        $this->assertFileExists($input_file);
        $fs->mkdir($output_dir);
        $this->assertFileExists($output_dir);

        $uuid = T::CopyFileToUuid($input_dir, $output_dir)->transform('file.pdf');
        $this->assertRegExp('/^[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}$/', $uuid);
        $output_file = $output_dir.'/'.$uuid;
        $this->assertFileExists($output_file);

        // Cleanup
        $fs->remove(array($input_dir, $output_dir));
        $this->assertFileNotExists($input_dir);
        $this->assertFileNotExists($output_dir);
    }
}
