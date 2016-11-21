<?php namespace Grinza;

class Application
{
    private $path;
    private $bindings;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get($abstract)
    {
        return $this->bindings[$abstract];
    }
}