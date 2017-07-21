<?php namespace Grinza\Logger\Formatters;

use Grinza\Logger\Record;

class JsonFormatter implements FormatterInterface
{

    public function format(Record $record): string
    {
        return $record->toJson();
    }
}