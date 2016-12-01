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
        $record = new Record('hey');

        $this->assertEquals('hey'               , $record->getMessage());
        $this->assertEquals(LogLevel::DEBUG     , $record->getLevel());
        $this->assertInstanceOf(DateTime::class , $record->getDatetime());
        $this->assertEquals([]                  , $record->getContext());
        $this->assertEquals([]                  , $record->getExtra());

        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($message, $now, $level, $context, $extra);

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
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($message, $now, $level, $context, $extra);

        $this->assertEquals([
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
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($message, $now, $level, $context, $extra);

        $json = json_encode([
            'dateTime' => $now,
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'extra'    => $extra
        ], JSON_PRETTY_PRINT);

        $this->assertEquals($json, $record->toJson());

        $json = json_encode([
            'dateTime' => $now,
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'extra'    => $extra
        ], 0);

        $this->assertEquals($json, $record->toJson(false));
    }
}