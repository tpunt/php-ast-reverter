<?php

use AstReverter\AstReverter;
use function ast\parse_code;
use PHPUnit\Framework\TestCase;

require_once 'vendor/autoload.php';

class AstReverterTest extends TestCase
{
    public function testAstReverterV30()
    {
        echo "\nphp-ast v30 tests:\n";
        $this->abstractTestAstReverter(30);
    }

    public function testAstReverterV35()
    {
        echo "\nphp-ast v35 tests:\n";
        $this->abstractTestAstReverter(35);
    }

    public function testAstReverterV40()
    {
        echo "\nphp-ast v40 tests:\n";
        $this->abstractTestAstReverter(40);
    }

    private function abstractTestAstReverter($version)
    {
        $testsDir = __DIR__ . '/AstReverterTests/';
        $dirIter = new \DirectoryIterator($testsDir);
        $this->astReverter = new AstReverter();

        foreach ($dirIter as $file) {
            $fileName = $file->getFileName();
            $fileParts = explode('.', $fileName);
            $extension = end($fileParts);

            if ($fileParts[1] !== 'test') {
                continue;
            }

            $file = file_get_contents("{$testsDir}{$fileName}");
            $test = explode('<=======>', $file);
            $name = trim($test[0]);
            $minVersion = trim($test[1]);
            $input = trim($test[2]);
            $expected = ltrim($test[3]) . PHP_EOL;

            if (version_compare(PHP_VERSION, $minVersion) < 0) {
                continue;
            }

            echo "Running {$fileParts[0]} tests\n";
            $this->assertEquals($expected, $this->astReverter->getCode(parse_code($input, $version)), "{$name} ({$fileParts[0]})");
        }
    }
}
