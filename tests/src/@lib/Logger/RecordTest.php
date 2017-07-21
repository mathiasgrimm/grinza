<?php

use Grinza\Logger\Record;
use Psr\Log\LogLevel;

class RecordTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_works()
    {
        $record = new Record('testing', 'hey');

        $this->assertEquals('testing'           , $record->getChannel());
        $this->assertEquals('hey'               , $record->getMessage());
        $this->assertEquals(LogLevel::DEBUG     , $record->getLevel());
        $this->assertInstanceOf(DateTime::class , $record->getDatetime());
        $this->assertEquals([]                  , $record->getContext());
        $this->assertEquals([]                  , $record->getExtra());

        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $this->assertEquals($channel , $record->getChannel());
        $this->assertEquals($message , $record->getMessage());
        $this->assertEquals($level   , $record->getLevel());
        $this->assertSame($now       , $record->getDatetime());
        $this->assertEquals($context , $record->getContext());
        $this->assertEquals($extra   , $record->getExtra());
    }

    /**
     * @test
     */
    public function toArray_works()
    {
        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $this->assertEquals([
            'channel'  => $channel,
            'message'  => $message,
            'dateTime' => $now,
            'level'    => $level,
            'context'  => $context,
            'extra'    => $extra
        ], $record->toArray());
    }

    /**
     * @test
     */
    public function toJson_works()
    {
        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $json = json_encode([
            'channel'  => $channel,
            'dateTime' => $now,
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'extra'    => $extra
        ], 0);

        $this->assertEquals($json, $record->toJson());
    }

    /**
     * @test
     */
    public function addExtra_works()
    {
        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $record->addExtra('value1', 'name1');
        $record->addExtra('value2');

        $expected = [
            'extra_key' => 'extra_value',
            'name1'     => 'value1',
            0           => 'value2',
        ];

        $actual = $record->getExtra();

        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual);
    }
}