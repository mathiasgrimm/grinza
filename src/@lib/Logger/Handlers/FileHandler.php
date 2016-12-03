<?php namespace Grinza\Logger\Handlers;

use Grinza\Logger\Formatters\FormatterInterface;
use Grinza\Logger\Processors\ProcessorInterface;
use Grinza\Logger\Record;

class FileHandler implements HandlerInterface
{
    private $fileName;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /** @var  ProcessorInterface [] */
    private $processors = [];

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     * @return FileHandler
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return FormatterInterface
     */
    public function getFormatter(): FormatterInterface
    {
        return $this->formatter;
    }

    /**
     * @param FormatterInterface $formatter
     * @return FileHandler
     */
    public function setFormatter(FormatterInterface $formatter): FileHandler
    {
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * @return ProcessorInterface[]
     */
    public function getProcessors(): array
    {
        return $this->processors;
    }

    /**
     * @param ProcessorInterface[] $processors
     * @return FileHandler
     */
    public function setProcessors(array $processors): FileHandler
    {
        foreach ($processors as $processor) {
            $this->addProcessors($processor);
        }

        return $this;
    }

    public function addProcessors(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
        return $this;
    }

    public function __construct($fileName, FormatterInterface $formatter, array $processors = [])
    {
        $this->fileName  = $fileName;
        $this->formatter = $formatter;

        $this->setProcessors($processors);
    }

    public function handle(Record $record)
    {
        foreach ($this->processors as $processor) {
            $output = $processor->process($record);

            if ($output) {
                if (is_array($output)) {
                    foreach ($output as $k => $v) {
                        $record->addExtra($v, $k);
                    }
                } else {
                    $record->addExtra($output);
                }
            }
        }

        $output = $this->formatter->format($record);

        file_put_contents($this->fileName, $output, FILE_APPEND);
    }
}