<?php namespace Grinza\Http;

use MathiasGrimm\ArrayPath\ArrayPath;

class Request
{
    private $server;
    private $request;
    private $files;
    private $inputReader;

    /**
     * @return mixed
     */
    public function getInputReader()
    {
        return $this->inputReader;
    }

    /**
     * @param mixed $inputReader
     * @return Request
     */
    public function setInputReader(InputReaderInterface $inputReader)
    {
        $this->inputReader = $inputReader;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     * @return Request
     */
    public function setServer(array $server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     * @return Request
     */
    public function setRequest(array $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     * @return Request
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
        return $this;
    }

    public function __construct(
        array $server                     = [],
        array $request                    = [],
        array $files                      = [],
        InputReaderInterface $inputReader = null
    ) {
        $this->server      = $server;
        $this->request     = $request;
        $this->files       = $files;
        $this->inputReader = $inputReader;
    }

    public function loadFromGlobals()
    {
        $server = isset($_SERVER)  ? $_SERVER  : [];
        $files  = isset($_FILES)   ? $_FILES   : [];
        $data   = isset($_REQUEST) ? $_REQUEST : [];

        if (isset($server['CONTENT_TYPE']) && preg_match('/json/i', $server['CONTENT_TYPE'])) {
            $data = array_merge($_GET, $_COOKIE);

            $content = $this->inputReader->read();

            if ($content) {
                $data = array_merge(json_decode($content, true), $data);
            }
        }

        $this->server  = $server;
        $this->files   = $files;
        $this->request = $data;

        return $this;
    }

    public function get($index, $default = null)
    {
        return ArrayPath::get($this->request, $index, $default);
    }
}