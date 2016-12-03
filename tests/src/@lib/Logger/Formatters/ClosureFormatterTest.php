<?php

use Grinza\Logger\Formatters\ClosureFormatter;
use Grinza\Logger\Record;
use Psr\Log\LogLevel;

class ClosureFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function it_works()
    {
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($message, $now, $level, $context, $extra);
        $formatter = new ClosureFormatter(function (Record $record) {
            return '->' . $record->getMessage() . '<-';
        });

        $formatted = $formatter->format($record);
        $this->assertEquals('->hey<-', $formatted);
    }

    /**
     * @test
     */
    public function constructor_only_accepts_callable_and_is_mandatory()
    {
        try {
            new ClosureFormatter();
            $this->fail('should fail when there is no argument passed');
        } catch (\Error $e) {}

        $this->assertEquals(1, preg_match('/Too few arguments to function/', $e->getMessage()));

        try {
            new ClosureFormatter('123');
            $this->fail('should fail when argument is not callable');
        } catch (\Error $e) {}

        $this->assertEquals(1, preg_match('/__construct\(\) must be callable/', $e->getMessage()));

    }
}