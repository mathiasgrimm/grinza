<?php namespace Grinza\Http;

class PhpInputStreamReader implements InputReaderInterface
{
    public function read()
    {
        return file_get_contents('php://input');
    }
}