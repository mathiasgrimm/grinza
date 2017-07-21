<?php

use Grinza\Logger\Processors\HostnameProcessor;
use Grinza\Logger\Record;
use Psr\Log\LogLevel;

class FileLineProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function it_processes()
    {
        $channel = 'testing';
        $message = 'hey';
        $now     = new DateTime();
        $level   = LogLevel::EMERGENCY;
        $context = ['conter_key' => 'context_value'];
        $extra   = ['extra_key'  => 'extra_value'];

        $record = new Record($channel, $message, $now, $level, $context, $extra);

        $hostname  = gethostname();
        $processor = new HostnameProcessor();
        $actual    = $processor->process($record);

        $this->assertEquals($hostname, $actual);
    }
}