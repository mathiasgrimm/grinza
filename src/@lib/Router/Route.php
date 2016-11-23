<?php namespace Grinza\Router;

use Closure;

class Route
{
    private $name;
    private $httpMethod;
    private $pattern;
    private $action;

    /**
     * @return null|string|Closure
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return Route
     */
    public function setAction($action): self
    {
        if (!$this->isActionClosure($action) && !$this->isActionMethod($action)) {
            throw new \InvalidArgumentException('Action must be either a string (controller@method) or a closure');
        }

        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Route
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpMethod(): ?string
    {
        return $this->httpMethod;
    }

    /**
     * @param mixed $httpMethod
     * @return Route
     */
    public function setHttpMethod(?string $httpMethod): self
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * @param mixed $pattern
     * @return Route
     */
    public function setPattern(?string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Route constructor.
     * @param null|string $name
     * @param null|string $httpMethod
     * @param null|string $pattern
     * @param null|string $action
     */
    public function __construct(
        string $name       = null,
        string $httpMethod = null,
        string $pattern    = null,
        string $action     = null
    )
    {
        $this->name       = $name;
        $this->httpMethod = $httpMethod;
        $this->pattern    = $pattern;

        if ($action) {
            $this->setAction($action);
        }
    }

    /**
     * Returns the list of named params.
     * eg.: for a route with a pattern equals to /user/{id}/{other}
     * it will return ['id', 'other']
     *
     * If there are not named parameters it will return null
     * @return null|array
     */
    public function getNamedParams(): ?array
    {
        $params = null;

        preg_match_all('~\{([^\/]+)\}~', $this->pattern, $namedParams);

        if (isset($namedParams[1]) && !empty($namedParams[1])) {
            $params = $namedParams[1];
        }

        return $params;
    }

    public function isActionClosure($action = null): bool
    {
        if (!func_num_args()) {
            $action = $this->action;
        }

        return is_a($action, Closure::class);
    }

    public function isActionMethod($action = null): bool
    {
        if (!func_num_args()) {
            $action = $this->action;
        }

        return (is_string($action) && strstr($action, '@'));
    }
}