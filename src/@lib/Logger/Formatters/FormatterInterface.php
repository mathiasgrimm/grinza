<?php namespace Grinza\Logger\Formatters;

use Grinza\Logger\Record;

interface FormatterInterface
{
    public function format(Record $record): string;
}