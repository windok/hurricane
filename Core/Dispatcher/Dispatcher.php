<?php

namespace Hurricane\Dispatcher;

use Hurricane\Exceptions\HurricaneException;
use Hurricane\Request\Request;
use Hurricane\Router\Router;
use Hurricane\ServiceLocator\ServiceLocator;

class Dispatcher
{

    /**
     * @var ServiceLocator
     */
    private $serviceLocator = null;

    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
    }

    public function dispatch()
    {
        $route = $this->getRouter()->resolve($this->getRequest());

        $fullControllerName = $this->getRouter()->getDefaultControllerNamespace() . $route->getNamespace() . ucfirst($route->getController()) . 'Controller';
        $actionName = $route->getAction() . 'Action';

        if (!method_exists($fullControllerName, $actionName)) {
            throw new HurricaneException('Dispatcher Error: action ' . $actionName . ' was not found in ' . $fullControllerName);
        }

        $controller = new $fullControllerName($this->getServiceLocator());
        if ($controller->beforeExecuteRoute()) {
            $controller->$actionName();
            $controller->afterExecuteRoute();
        }
    }

    /**
     * @return ServiceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @return Router
     * @throws \Hurricane\Exceptions\HurricaneException
     */
    private function getRouter()
    {
        return $this->getServiceLocator()->get('router');
    }

    /**
     * @return Request
     * @throws \Hurricane\Exceptions\HurricaneException
     */
    private function getRequest()
    {
        return $this->getServiceLocator()->get('request');
    }

    /**
     * @param ServiceLocator $serviceLocator
     * @return Dispatcher
     */
    public function setServiceLocator(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

}