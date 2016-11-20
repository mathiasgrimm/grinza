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
        $match  = null;

        /** @var Route $route */
        foreach ($routes as $route) {
            $pattern = trim($route->getPattern(), '/');

            if ($pattern == $urn) {
                $match = new Match(null, $route);
                break;
            } else {
                $regexPattern = '#^' . preg_replace('/\\\\{(.*?)\\\\}/', '([^\/]+)', preg_quote($pattern)) . '$#';

                if (preg_match($regexPattern, $urn, $params)) {
                    // removing the first entry which is the full string.
                    array_shift($params);

                    $match = new Match($params, $route);
                    break;
                }
            }
        }

        return $match;
    }
}