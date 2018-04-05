<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22/01/18
 * Time: 18:05
 */



use PHPUnit\Framework\TestCase;

class RecursiveDirectoryIteratorTest extends TestCase {

    private $file;

    public function setUp()
    {
        $file =  new \Ballybran\Helpers\Http\RecursiveDirectoryIterator('tests', FilesystemIterator::CURRENT_AS_FILEINFO);


            return $this->file = $file->current();

    }

    public function testOpenFile()
    {
        $t  = 'tests';
        $this->assertFileExists($t, $this->file);
    }
}