<?php namespace Grinza\Logger;


use Psr\Log\LogLevel;

class Record
{
    private $dateTime;
    private $level;
    private $message;
    private $context;
    private $extra = [];

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
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    public function addExtra($value, $name = null): self
    {
        if ($name) {
            $this->extra[$name] = $value;
        } else {
            $this->extra[] = $value;
        }

        return $this;
    }

    public function __construct(string $message, \DateTime $dateTime = null, $level = LogLevel::DEBUG, array $context = [], array $extra = [])
    {
        if (!$dateTime) {
            $dateTime = new \DateTime();
        }

        $this->dateTime = $dateTime;
        $this->message  = $message;
        $this->context  = $context;
        $this->level    = $level;

        foreach ($extra as $k => $v) {
            $this->addExtra($v, $k);
        }
    }

    public function toArray()
    {
        return [
            'dateTime' => $this->dateTime,
            'message'  => $this->message,
            'context'  => $this->context,
            'level'    => $this->level,
            'extra'    => $this->extra,
        ];
    }

    public function toJson($pretty = true)
    {
        $options = 0;

        if ($pretty) {
            $options = JSON_PRETTY_PRINT;
        }

        return json_encode($this->toArray(), $options);
    }
}