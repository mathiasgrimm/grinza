<?php

use Grinza\Logger\Formatters\JsonFormatter;
use Grinza\Logger\Handlers\FileHandler;
use Grinza\Logger\Processors\ClosureProcessor;
use Grinza\Logger\Processors\HostnameProcessor;
use Grinza\Logger\Record;
use Psr\Log\LogLevel;

class FileHandlerTest extends TestCase
{
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
        @unlink('/tmp/test.out');
    }

    /**
     * @test
     */
    public function getters_and_setters()
    {
        $formatter  = new JsonFormatter();
        $processor1 = new HostnameProcessor();
        $processor2 = new ClosureProcessor(function (Record $record) {
            return [
                'hash' => md5($record->getMessage())
            ];
        });

        $handler = new FileHandler('/tmp/test.out', $formatter, [
            $processor1,
            $processor2
        ]);

        $this->assertSame($formatter, $handler->getFormatter());
        $this->assertEquals([$processor1, $processor2], $handler->getProcessors());
        $this->assertEquals('/tmp/test.out', $handler->getFileName());

        $handler->setFileName('/tmp/test2.out');
        $this->assertEquals('/tmp/test2.out', $handler->getFileName());

        $formatter  = new JsonFormatter();
        $handler->setFormatter($formatter);
        $this->assertSame($formatter, $handler->getFormatter());

        $handler->setProcessors([]);
        $this->assertEquals([], $handler->getProcessors());

        $handler->setProcessors([
            $processor1 = new HostnameProcessor()
        ]);
        $this->assertEquals([$processor1], $handler->getProcessors());

        $processor2 = new HostnameProcessor();
        $handler->addProcessors($processor2);

        $this->assertEquals([$processor1, $processor2], $handler->getProcessors());

    }
    /**
     * @test
     */
    public function it_works()
    {
        $handler = new FileHandler('/tmp/test.out', new JsonFormatter(), [
            new HostnameProcessor(),
            new ClosureProcessor(function (Record $record) {
                return [
                    'hash' => md5($record->getMessage())
                ];
            })
        ]);

        $channel  = 'testing';
        $message  = 'hey';
        $hash     = md5($message);
        $now      = new DateTime();
        $tzType   = ((array) $now->getTimezone())['timezone_type'];
        $tz       = $now->getTimezone()->getName();
        $hostname = gethostname();
        $nowSt    = $now->format('Y-m-d H:i:s.u');
        $level    = LogLevel::EMERGENCY;
        $context  = ['conter_key' => 'context_value'];
        $extra    = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $handler->handle($record);

        $expected = '{"channel":"testing","dateTime":{"date":"' . $nowSt . '","timezone_type":' . $tzType . ',"timezone":"' . $tz . '"},"message":"hey","context":{"conter_key":"context_value"},"level":"emergency","extra":{"extra_key":"extra_value","0":"' . $hostname . '","hash":"' . $hash . '"}}' . PHP_EOL;
        $actual   = file_get_contents('/tmp/test.out');

        $this->assertEquals($expected, $actual);
    }


}