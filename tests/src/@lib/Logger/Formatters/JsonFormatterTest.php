<?php

use Grinza\Logger\Formatters\JsonFormatter;
use Grinza\Logger\Record;
use Psr\Log\LogLevel;

class JsonFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function it_formats()
    {
        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $formatter = new JsonFormatter();
        $actual    = $formatter->format($record);

        $json = json_encode([
            'channel'  => $channel,
            'dateTime' => $now,
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'extra'    => $extra
        ], 0);

        $this->assertEquals($json, $actual);
    }
}