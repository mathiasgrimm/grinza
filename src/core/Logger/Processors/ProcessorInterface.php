<?php namespace Grinza\Logger\Processors;

use Grinza\Logger\Record;

interface ProcessorInterface
{
    public function process(Record $record);
}