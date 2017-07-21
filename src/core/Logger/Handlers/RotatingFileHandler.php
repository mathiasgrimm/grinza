<?php namespace Grinza\Logger\Handlers;

use Grinza\Logger\Formatters\FormatterInterface;
use Grinza\Logger\Record;

class RotatingFileHandler extends FileHandler
{
    protected $maxFiles;

    public function __construct($fileName, $maxFiles, FormatterInterface $formatter, array $processors = [])
    {
        $this->maxFiles = $maxFiles;

        parent::__construct($fileName, $formatter, $processors);
    }

    protected function write(Record $record)
    {
        $this->getFileNameForRecord();
    }

    public function getFileNameForRecord(Record $record)
    {

    }
}