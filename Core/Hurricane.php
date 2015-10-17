<?php

namespace Hurricane;

use Hurricane\Dispatcher\Dispatcher;
use Hurricane\Request\Request;
use Hurricane\ServiceLocator\ServiceLocator;

class Hurricane
{

    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * Hurricane constructor.
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
    }

    public function handle()
    {
        $this->getRequest()->initialize();
        $this->getDispatcher()->dispatch();
    }

    /**
     * @return Request
     * @throws Exceptions\HurricaneException
     */
    private function getRequest()
    {
        return $this->getServiceLocator()->get('request');
    }

    /**
     * @return Dispatcher
     * @throws Exceptions\HurricaneException
     */
    private function getDispatcher()
    {
        return $this->getServiceLocator()->get('dispatcher');
    }

    /**
     * @return ServiceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param ServiceLocator $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

}