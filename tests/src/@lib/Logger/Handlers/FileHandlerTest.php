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


        $message = 'hey';
        $hash    = md5($message);
        $now     = new DateTime();
        $nowSt   = $now->format('Y-m-d H:i:s.u');
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($message, $now, $level, $context, $extra);

        $handler->handle($record);

        $actual = file_get_contents('/tmp/test.out');

        $expected = <<<EXPECTED
{
    "dateTime": {
        "date": "{$nowSt}",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "message": "hey",
    "context": {
        "conter_key": "context_value"
    },
    "level": "emergency",
    "extra": {
        "extra_key": "extra_value",
        "0": "7faf154ce003",
        "hash": "{$hash}"
    }
}
EXPECTED;

        $this->assertEquals($expected, $actual);

        $this->deleteFile();

        $handler = new FileHandler('/tmp/test.out', new JsonFormatter(false), [
            new HostnameProcessor(),
            new ClosureProcessor(function (Record $record) {
                return [
                    'hash' => md5($record->getMessage())
                ];
            })
        ]);

        $handler->handle($record);

        $expected = '{"dateTime":{"date":"' . $nowSt . '","timezone_type":3,"timezone":"UTC"},"message":"hey","context":{"conter_key":"context_value"},"level":"emergency","extra":{"extra_key":"extra_value","0":"7faf154ce003","hash":"' . $hash . '","1":"7faf154ce003"}}';
        $actual   = file_get_contents('/tmp/test.out');
        $this->assertEquals($expected, $actual);
    }


}