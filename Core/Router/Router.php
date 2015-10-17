<?php

namespace Hurricane\Router;

use Hurricane\Exceptions\HurricaneException;
use Hurricane\Request\Request;

class Router
{

    /**
     * @var Route[]
     */
    private $routes = [];
    /**
     * @var Route
     */
    private $errorRoute = null;
    /**
     * @var string
     */
    private $defaultControllerNamespace = '';
    /**
     * @var bool
     */
    private $removeExtraSlashes = false;
    /**
     * @var Route
     */
    private $resolvedRoute = null;

    public function resolve(Request $request)
    {
        $dividedRequestURI = explode('/', $request->getURI());

        foreach ($this->routes as $route) {
            if (!in_array($request->getMethod(), $route->getMethods(), true)) {
                continue;
            }

            if ($route->matchRequestURI($dividedRequestURI)) {
                $this->setResolvedRoute($route);
                return $route;
            }
        }

        if (!$this->errorRoute) {
            return $this->errorRoute;
        }

        throw new HurricaneException('404 Error!');
    }

    /**
     * @param Route $route
     * @return Router
     */
    public function add(Route $route)
    {
        $this->routes[] = $route;
        return $this;
    }

    /**
     * @param Route[] $routes
     * @return Router
     */
    public function addAll(array $routes)
    {
        $this->routes = array_merge($this->routes, $routes);
        return $this;
    }

    public function notFound(Route $route)
    {
        $this->errorRoute = $route;
        return $this;
    }

    /**
     * @return Router
     */
    public function removeExtraSlashes()
    {
        $this->removeExtraSlashes = true;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultControllerNamespace()
    {
        return $this->defaultControllerNamespace;
    }

    /**
     * @param string $defaultControllerNamespace
     * @return Router
     */
    public function setDefaultControllerNamespace($defaultControllerNamespace)
    {
        $this->defaultControllerNamespace = $defaultControllerNamespace;
        return $this;
    }

    /**
     * @return Route
     */
    public function getResolvedRoute()
    {
        return $this->resolvedRoute;
    }

    /**
     * @param Route $resolvedRoute
     * @return Router
     */
    private function setResolvedRoute(Route $resolvedRoute)
    {
        $this->resolvedRoute = $resolvedRoute;
        return $this;
    }


}
