<?php namespace Grinza\Logger\Formatters;

use Grinza\Logger\Record;

class ClosureFormatter implements FormatterInterface
{
    private $closure;

    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    public function format(Record $record): string
    {
        $closure = $this->closure;
        return $closure($record);
    }
}