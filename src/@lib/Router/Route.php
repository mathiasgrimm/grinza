<?php namespace Grinza\Router;

class Route
{
    private $name;
    private $httpMethod;
    private $pattern;
    private $controller;
    private $controllerMethod;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Route
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @param mixed $httpMethod
     * @return Route
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param mixed $pattern
     * @return Route
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     * @return Route
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getControllerMethod()
    {
        return $this->controllerMethod;
    }

    /**
     * @param mixed $controllerMethod
     * @return Route
     */
    public function setControllerMethod($controllerMethod)
    {
        $this->controllerMethod = $controllerMethod;
        return $this;
    }

    /**
     * Route constructor
     * @param null $name
     * @param null $httpMethod
     * @param null $pattern
     * @param null $controller
     * @param null $controllerMethod
     */
    public function __construct(
        $name             = null,
        $httpMethod       = null,
        $pattern          = null,
        $controller       = null,
        $controllerMethod = null
    ) {
        $this->name             = $name;
        $this->httpMethod       = $httpMethod;
        $this->pattern          = $pattern;
        $this->controller       = $controller;
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * Returns the list of named params.
     * eg.: for a route with a pattern equals to /user/{id}/{other}
     * it will return ['id', 'other']
     *
     * If there are not named parameters it will return null
     *
     * @return null|array
     */
    public function getNamedParams()
    {
        $params = null;

        preg_match_all('~\{([^\/]+)\}~', $this->pattern, $namedParams);

        if (isset($namedParams[1]) && !empty($namedParams[1])) {
            $params = $namedParams[1];
        }

        return $params;
    }
}