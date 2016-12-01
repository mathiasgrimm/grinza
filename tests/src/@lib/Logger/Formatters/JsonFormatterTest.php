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
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($message, $now, $level, $context, $extra);

        $formatter = new JsonFormatter();
        $actual    = $formatter->format($record);

        $json = json_encode([
            'dateTime' => $now,
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'extra'    => $extra
        ], JSON_PRETTY_PRINT);

        $this->assertEquals($json, $actual);

        $formatter = new JsonFormatter(false);
        $actual    = $formatter->format($record);

        $json = json_encode([
            'dateTime' => $now,
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'extra'    => $extra
        ], 0);

        $this->assertEquals($json, $actual);
    }
}