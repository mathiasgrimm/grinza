<?php namespace Grinza\Logger\Processors;

use Grinza\Logger\Record;

class ClosureProcessor implements ProcessorInterface
{
    private $closure;

    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    public function process(Record $record)
    {
        $closure = $this->closure;
        return $closure($record);
    }
}