<?php

namespace App\router;

use App\router\RouterException;

/**
 * Class manage the path and callback
 */
class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];
    private $routeException;

    public function __construct($url)
    {
        $this->url = $url;
        $this->routeException = new RouterException;
    }

    /**
     * adding route to get array
     */
    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * adding route to post array
     */
    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * add a new route
     */
    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * check if a route match with an register route and return callback
     */
    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            $this->routeException->error404();
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        $this->routeException->error404();
    }
}
