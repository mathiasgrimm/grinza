<?php namespace Grinza\Logger;


use Psr\Log\LogLevel;

class Record
{
    private $message;
    private $context;
    private $level;
    private $datetime;
    private $extra;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    public function __construct(\DateTimeImmutable $datetime, $level = LogLevel::DEBUG, string $message, array $context = [], array $extra = [])
    {
        $this->datetime = $datetime;
        $this->message  = $message;
        $this->context  = $context;
        $this->level    = $level;
        $this->extra    = $extra;
    }
}