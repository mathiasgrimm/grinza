<?php namespace Grinza\Router;

class Matcher
{
    /**
     * @param array $routeCollection
     * @param $urn
     * @param $httpMethod
     * @return null|Match
     */
    public function match(RouteCollection $routes, $urn, $httpMethod)
    {
        $urn    = trim($urn, '/');
        $routes = \A::get($routes->getRoutes(), $httpMethod, []);

        /** @var Route $route */
        foreach ($routes as $route) {
            if ($route->getPattern() == $urn) {
                return new Match(null, $route);
            } else {
                $pattern      = trim($route->getPattern(), '/');
                $regexPattern = '#^' . preg_replace('/\\\\{(.*?)\\\\}/', '([^\/]+)', preg_quote($pattern)) . '$#';

                if (preg_match($regexPattern, $urn, $params)) {
                    // removing the first entry which is the full string.
                    array_shift($params);

                    return new Match($params, $route);
                }
            }
        }
    }
}