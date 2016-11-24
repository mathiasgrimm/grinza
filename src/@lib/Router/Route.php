<?php namespace Grinza\Router;

use Closure;
use InvalidArgumentException;

class Route
{
    private $name;
    private $httpMethods = [];
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
        if (null !== $action && !$this->isActionClosure($action) && !$this->isActionMethod($action)) {
            throw new InvalidArgumentException('Action must be either a string (controller@method), a closure or null');
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
     * @return null|array
     */
    public function getHttpMethods(): array
    {
        return $this->httpMethods;
    }

    /**
     * @param mixed $httpMethods
     * @return Route
     */
    public function setHttpMethods(array $httpMethods): self
    {
        $this->httpMethods = $httpMethods;
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
     * @param null|array|string $httpMethods
     * @param null|string $pattern
     * @param null|string $action
     */
    public function __construct(
        string $name        = null,
        array  $httpMethods = [],
        string $pattern     = null,
        string $action      = null
    )
    {
        $this->setName($name);
        $this->setPattern($pattern);
        $this->setHttpMethods($httpMethods);
        $this->setAction($action);
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