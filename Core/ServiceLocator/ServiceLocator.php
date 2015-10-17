<?php

namespace Hurricane\ServiceLocator;

use Hurricane\Exceptions\HurricaneException;

class ServiceLocator
{

    /**
     * @var ServiceLocatorElement[]
     */
    private $serviceLocatorElements = [];

    /**
     * @param $name
     * @param $service
     * @return ServiceLocator
     */
    public function set($name, $service)
    {
        $this->serviceLocatorElements[$name] = new ServiceLocatorElement($name, false, $service);
        return $this;
    }

    /**
     * @param $name
     * @param $service
     * @return ServiceLocator
     */
    public function setShared($name, $service)
    {
        $this->serviceLocatorElements[$name] = new ServiceLocatorElement($name, true, $service);
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     * @throws HurricaneException
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new HurricaneException('Requested service (' . $name . ') does not exist in ServiceLocator!');
        }

        return $this->serviceLocatorElements[$name]->resolve();
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->getServiceLocatorElements());
    }

    /**
     * @return ServiceLocatorElement[]
     */
    public function getServiceLocatorElements()
    {
        return $this->serviceLocatorElements;
    }

    /**
     * @param ServiceLocator $serviceLocator
     * @return $this
     */
    public function merge(ServiceLocator $serviceLocator)
    {
        $this->serviceLocatorElements = array_merge(
            $this->getServiceLocatorElements(),
            $serviceLocator->getServiceLocatorElements()
        );

        return $this;
    }

}