<?php namespace Grinza\Logger\Processors;

use Grinza\Logger\Record;

class HostnameProcessor implements ProcessorInterface
{
    public function process(Record $record)
    {
        return gethostname();
    }
}