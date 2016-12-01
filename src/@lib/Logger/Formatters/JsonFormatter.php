<?php namespace Grinza\Logger\Formatters;

use Grinza\Logger\Record;

class JsonFormatter implements FormatterInterface
{
    private $pretty;

    public function __construct($pretty = true)
    {
        $this->pretty = $pretty;
    }

    public function format(Record $record): string
    {
        return $record->toJson($this->pretty);
    }
}