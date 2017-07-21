<?php

use Grinza\Logger\Formatters\JsonFormatter;
use Grinza\Logger\Handlers\FileHandler;
use Grinza\Logger\Logger;

class LoggerTest extends TestCase
{
    private $fileName = '/tmp/test.log';
    public function setUp()
    {
        parent::setUp();
        $this->deleteFile();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->deleteFile();
    }

    private function deleteFile()
    {
        @unlink($this->fileName);
    }

    /**
     * @test
     */
    public function constructor_works()
    {
        $formatter = new JsonFormatter();

        $handlers = [
            new FileHandler('/tmp/test.log', $formatter)
        ];

        $channel = 'testing';

        $logger = new Logger($channel, $handlers);

        $this->assertEquals($channel, $logger->getName());
        $this->assertSame($handlers, $logger->getHandlers());
    }

    /**
     * @test
     */
    public function getters_and_setters()
    {
        $formatter = new JsonFormatter();

        $handlers = [
            $h1 = new FileHandler('/tmp/test.log', $formatter)
        ];

        $channel = 'testing';

        $logger = new Logger($channel);

        $this->assertEquals([], $logger->getHandlers());

        $logger->setName('another');
        $this->assertEquals('another', $logger->getName());

        $logger->setHandlers($handlers);
        $this->assertSame($handlers, $logger->getHandlers());

        $h2 = new FileHandler('/tmp/test2.log', $formatter);

        $logger->addHandler($h2);
        $this->assertEquals([$h1, $h2], $logger->getHandlers());

        try {
            $logger->addHandler(new class{});
            $this->fail('should not get here');
        } catch (Error $e) {}

        $this->assertEquals(1, preg_match('/HandlerInterface/', $e->getMessage()));
    }

    /**
     * @test
     */
    public function it_logs_with_single_handler()
    {
        $formatter = new JsonFormatter();

        $handlers = [
            $h1 = new FileHandler($this->fileName, $formatter)
        ];

        $channel = 'testing';

        $logger = new Logger($channel, $handlers);
        $logger->debug('message 1');
        $logger->debug('message 2');

        $content = file_get_contents($this->fileName);

        $records = explode("\n", $content);
        array_pop($records); // removing empy record

        $this->assertCount(2, $records);

    }

    /**
     * @test
     */
    public function it_logs_with_multi_handlers()
    {
        @unlink('/tmp/test2.log');

        $formatter = new JsonFormatter();

        $handlers = [
            $h1 = new FileHandler($this->fileName, $formatter),
            $h2 = new FileHandler('/tmp/test2.log', $formatter),
        ];

        $channel = 'testing';

        $logger = new Logger($channel, $handlers);
        $logger->debug('message 1');
        $logger->debug('message 2');

        $content = file_get_contents($this->fileName);

        $records = explode("\n", $content);
        array_pop($records); // removing empty record

        $this->assertCount(2, $records);

        // second file
        $content = file_get_contents('/tmp/test2.log');

        $records = explode("\n", $content);
        array_pop($records); // removing empty record

        $this->assertCount(2, $records);

    }

}