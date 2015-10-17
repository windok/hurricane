<?php

namespace Hurricane\Router;

use Hurricane\Exceptions\HurricaneException;

class Route
{

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const PATCH = 'PATCH';
    const HEAD = 'HEAD';
    const OPTIONS = 'OPTIONS';

    private $validMethods = [
        self::GET,
        self::POST,
        self::PUT,
        self::DELETE,
        self::PATCH,
        self::HEAD,
        self::OPTIONS
    ];

    private $route = '';
    private $methods = [];
    private $controller = '';
    private $namespace = '';
    private $action = '';
    private $routeParams = [];

    /**
     * @param $route
     * @param $controller
     * @param $action
     * @throws HurricaneException
     */
    public function __construct($route, $controller, $action)
    {
        $this->setRoute($route)->setController($controller)->setAction($action);
    }


    public function matchRequestURI(array $dividedRequestURI)
    {
        $routeArray = explode('/', $this->getRoute());

        if (count($dividedRequestURI) !== count($routeArray)) {
            return false;
        }

        for ($i = 0, $count = count($routeArray); $i < $count; $i++) {
            if (strlen($routeArray[$i]) > 2 && $routeArray[$i][0] === '{' && $routeArray[$i][strlen($routeArray[$i]) - 1] === '}') {

                $routeElement = ltrim($routeArray[$i], '{');
                $routeElement = rtrim($routeElement, '}');

                $regexp = substr($routeElement, strpos($routeElement, ':') + 1);

                if (!preg_match('/^' . $regexp . '$/', $dividedRequestURI[$i])) {
                    return false;
                }

                $paramName = substr($routeElement, 0, strpos($routeElement, ':'));
                $this->addRouteParam($paramName, $dividedRequestURI[$i]);
                continue;
            }

            if ($routeArray[$i] !== $dividedRequestURI[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return Route
     */
    private function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @param $method
     * @return Route
     * @throws HurricaneException
     */
    public function via($method)
    {
        if (!in_array($method, $this->validMethods, true)) {
            throw new HurricaneException('Unaccepted method was set to route: ' . $method);
        }
        $this->methods[] = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     * @return Route
     */
    private function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return Route
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return Route
     */
    private function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * @param $paramName
     * @param $paramValue
     * @return Route
     */
    private function addRouteParam($paramName, $paramValue)
    {
        $this->routeParams[$paramName] = $paramValue;
        return $this;
    }

}