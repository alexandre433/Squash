<?php


namespace Squash\FileSystem;


use PHPUnit\Framework\TestCase;


class FileSystemTest extends TestCase
{
    private const FILES_TEST_FILE = __DIR__ . '/files/test.txt';

    private const FILES_NEW_FILE = __DIR__ . '/files/new-file.txt';

    private const FILES_DIR = __DIR__ . '/files/';

    public static function setUpBeforeClass(): void
    {
        mkdir(self::FILES_DIR);
    }

    public function setUp(): void
    {
        file_put_contents(self::FILES_TEST_FILE, '123');
    }

    public function tearDown(): void
    {
        unlink(self::FILES_TEST_FILE);
        if (is_file(self::FILES_NEW_FILE)) {
            unlink(self::FILES_NEW_FILE);
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (is_file(self::FILES_TEST_FILE)) {
            unlink(self::FILES_TEST_FILE);
        }

        rmdir(self::FILES_DIR);
    }

    public function testIsFileInDirectory(): void
    {
        $fs = new FileSystem();
        $this->assertTrue($fs->isFileInDirectory(self::FILES_DIR, 'test.txt'));
    }

    public function testIsFileInDirectoryNoFile(): void
    {
        $fs = new FileSystem();
        $this->assertFalse($fs->isFileInDirectory(self::FILES_DIR, 'no-file'));
    }

    public function testIsFileInDirectoryNotAFile(): void
    {
        $fs = new FileSystem();
        $this->assertFalse($fs->isFileInDirectory(__DIR__, '/files/'));
    }

    public function testListFilesInDirectory(): void
    {
        $fs = new FileSystem();
        $list = $fs->listFilesInDirectory(self::FILES_DIR);

        $files = explode(PHP_EOL, $list);
        foreach ($files as $file) {
            $this->assertFileExists($file);
        }
    }

    public function testReplaceFile(): void
    {
        $fs = new FileSystem();
        $fs->replaceFile(self::FILES_DIR, 'new-file.txt', 'test.txt');
        $this->assertFileEquals(self::FILES_TEST_FILE, self::FILES_NEW_FILE);
    }

    public function testReplaceFileDestinationExists(): void
    {
        file_put_contents(self::FILES_NEW_FILE, '321');

        $fs = new FileSystem();
        $fs->replaceFile(self::FILES_DIR, 'new-file.txt', 'test.txt');
        $this->assertFileEquals(self::FILES_TEST_FILE, self::FILES_NEW_FILE);
    }

    public function testReplaceFileDestinationHasSameContent(): void
    {
        file_put_contents(self::FILES_NEW_FILE, '123');

        $fs = new FileSystem();
        $fs->replaceFile(__DIR__ . '/files', 'new-file.txt', 'test.txt');
        $this->assertFileEquals(self::FILES_TEST_FILE, self::FILES_NEW_FILE);
    }
}
