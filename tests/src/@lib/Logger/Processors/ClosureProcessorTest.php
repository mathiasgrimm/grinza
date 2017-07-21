<?php

use Grinza\Logger\Processors\ClosureProcessor;
use Grinza\Logger\Record;
use Psr\Log\LogLevel;

class ClosureProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function it_works()
    {
        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);
        $processor = new ClosureProcessor(function (Record $record) {
            return 'something';
        });

        $output = $processor->process($record);
        $this->assertEquals('something', $output);

        $processor = new ClosureProcessor(function (Record $record) {
            return ['the_key' => 'the_value'];
        });

        $output = $processor->process($record);
        $this->assertEquals(['the_key' => 'the_value'], $output);
    }

    /**
     * @test
     */
    public function constructor_only_accepts_callable_and_is_mandatory()
    {
        try {
            new ClosureProcessor();
            $this->fail('should fail when there is no argument passed');
        } catch (\Error $e) {}

        $this->assertEquals(1, preg_match('/Too few arguments to function/', $e->getMessage()));

        try {
            new ClosureProcessor('123');
            $this->fail('should fail when argument is not callable');
        } catch (\Error $e) {}

        $this->assertEquals(1, preg_match('/__construct\(\) must be callable/', $e->getMessage()));

    }
}