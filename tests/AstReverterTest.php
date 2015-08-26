<?php

use AstReverter\AstReverter;
use function ast\parse_code;

class AstReverterTest extends \PHPUnit_Framework_TestCase
{
    private $astReverter = null;

    public function testAstReverter()
    {
        $testsDir = __DIR__ . '/AstReverterTests/';
        $dirIter = new \DirectoryIterator($testsDir);
        $this->astReverter = new AstReverter();

        foreach ($dirIter as $file) {
            $fileName = $file->getFileName();
            $fileParts = explode('.', $fileName);
            $extension = end($fileParts);

            if ($extension !== 'phpt') {
                continue;
            }

            $file = file_get_contents("{$testsDir}{$fileName}");
            $test = explode('<=======>', $file);
            $name = trim($test[0]);
            $input = trim($test[1]);
            $expected = ltrim($test[2]) . PHP_EOL;

            $this->assertEquals($this->astReverter->getCode(parse_code($input)), $expected, $name);
        }
    }
}
