<?php namespace Grinza\Router;

class RouteCollection
{
    private $routes = [];

    /**
     * Checks if the route has all required attributes
     *
     * @param Route $route
     * @throws \InvalidArgumentException
     * @return self
     */
    public function validate(Route $route): self
    {
        if (!$route->getHttpMethods()) {
            throw new \InvalidArgumentException('Route does not have httpMethod and therefore cant be added');
        }

        if (!$route->getPattern()) {
            throw new \InvalidArgumentException('Route does not have pattern and therefore cant be added');
        }

        if (!$route->getAction()) {
            throw new \InvalidArgumentException('Route does not have an action and therefore cant be added');
        }

        return $this;
    }

    /**
     * @param Route $route
     * @return RouteCollection
     */
    public function addRoute(Route $route): self
    {
        $this->validate($route);

        foreach ($route->getHttpMethods() as $httpMethod) {
            if ($name = $route->getName()) {
                $this->routes[$httpMethod][$name] = $route;
            } else {
                $this->routes[$httpMethod][] = $route;
            }
        }

        return $this;
    }

    /**
     * @param array $routes
     * @return RouteCollection
     */
    public function addRoutes(array $routes): self
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function deleteRoute(Route $route)
    {
        if (!$route->getHttpMethods() && !$route->getName()) {
            throw new \InvalidArgumentException('Route does not have name and httpMethods and therefore cant be deleted');
        }

        foreach ($route->getHttpMethods() as $httpMethod) {
            unset($this->routes[$httpMethod][$route->getName()]);

            // if it was the last element, delete also the index GET|POST etc
            if (count($this->routes[$httpMethod]) == 0) {
                unset($this->routes[$httpMethod]);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * RouteCollection constructor.
     * @param array|null $routes
     */
    public function __construct(array $routes = null)
    {
        if ($routes) {
            $this->addRoutes($routes);
        }
    }
}