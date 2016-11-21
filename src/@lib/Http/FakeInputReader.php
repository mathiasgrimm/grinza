<?php namespace Grinza\Http;

class FakeInputReader implements InputReaderInterface
{
    private $content;

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return FakeInputReader
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public function read()
    {
        return $this->content;
    }
}