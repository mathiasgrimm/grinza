<?php namespace Grinza\Logger;

use Grinza\Logger\Handlers\HandlerInterface;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    /**
     * @var HandlerInterface []
     */
    protected $handlers = [];

    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Logger
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function __construct($name, array $handlers = [])
    {
        $this->name = $name;

        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers(): array
    {
        return $this->handlers;
    }

    /**
     * @param HandlerInterface[] $handlers
     * @return Logger
     */
    public function setHandlers(array $handlers): Logger
    {
        if ($handlers) {
            foreach ($handlers as $handler) {
                $this->addHandler($handler);
            }
        } else {
            $this->handlers = [];
        }

        return $this;
    }

    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $now    = new \DateTime('now');
        $record = new Record($this->name, $message, $now, $level, $context);

        foreach ($this->handlers as $handler) {
            $handler->handle($record);
        }
    }
}