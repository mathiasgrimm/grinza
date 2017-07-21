<?php namespace Grinza\Router;

class Match
{
    private $params;
    private $route;

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     * @return Match
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     * @return Match
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function __construct(array $params = null, Route $route = null)
    {
        $this->params = $params;
        $this->route  = $route;
    }
}