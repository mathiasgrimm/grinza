<?php namespace Grinza\Router;

class Matcher
{
    /**
     * @param array $routeCollection
     * @param $urn
     * @param $httpMethod
     * @return null|Match
     */
    public function match(RouteCollection $routes, $urn, array $httpMethods)
    {
        $urn    = trim($urn, '/');

        foreach ($httpMethods as $httpMethod) {
            $routes = \A::get($routes->getRoutes(), $httpMethod, []);
            $match  = null;

            /** @var Route $route */
            foreach ($routes as $route) {
                $pattern = trim($route->getPattern(), '/');

                // if route is exaclty the same. For example if the route was defined as /user
                // and the url is /user, they will match and no regex is needed
                if ($pattern == $urn) {
                    $match = new Match(null, $route);
                    break;
                } else {
                    // gets ['id', 'theme', 'other']
                    $namedParams = $route->getNamedParams();

                    // this dynamically creates the regex that will find the named params in the url
                    // replaces {id} with (?P<id>[^\/]+)
                    // so for each named param it will replace it, as in
                    // /user/{id}/{theme}/show
                    // will be /user/(?P<id>[^\/]+)/(?P<theme>[^\/]+)/show
                    // the ?P<theme> is just to give a name for the param found, and the name is exactly the name of
                    // the named param
                    // and the [^\/] means anything that is not a / (forward slash)
                    $regexPattern = preg_replace('~\{([^\/]+)\}~', '(?P<${1}>[^\/]+)', $pattern);
                    $regexPattern = "~^{$regexPattern}$~";

                    if (preg_match($regexPattern, $urn, $params)) {
                        // removing the first entry which is the full string.
                        array_shift($params);

                        // mapping the values found in the url with the name params
                        $paramsTmp = [];
                        foreach ($namedParams as $paramName) {
                            $paramsTmp[$paramName] = $params[$paramName];
                        }

                        $match = new Match($paramsTmp, $route);
                        break;
                    }
                }
            }

        }



        return $match;
    }
}