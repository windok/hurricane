<?php

namespace Hurricane\ServiceLocator;

use Hurricane\Exceptions\HurricaneException;

class ServiceLocatorElement
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $shared;

    /**
     * @var mixed
     */
    private $declaration;

    /**
     * @var mixed
     */
    private $resolvedInstance;

    /**
     * @param $name
     * @param $shared
     * @param $declaration
     * @throws HurricaneException
     */
    public function __construct($name, $shared, $declaration)
    {
        $this->setName($name)
            ->setShared($shared)
            ->setDeclaration($declaration);
    }

    /**
     * @return mixed
     */
    public function resolve()
    {
        if (!$this->isShared()) {
            return $this->getDeclaration()->__invoke();
        }

        if ($this->getResolvedInstance() === null) {
            $instance = is_callable($this->getDeclaration()) ? $this->getDeclaration()->__invoke() : $this->getDeclaration();
            $this->setResolvedInstance($instance);
        }

        return $this->getResolvedInstance();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return ServiceLocatorElement
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * @param $shared
     * @return ServiceLocatorElement
     * @throws HurricaneException
     */
    public function setShared($shared)
    {
        if (!is_bool($shared)) {
            throw new HurricaneException('Shared property of ServiceLocatorElement has to be boolean');
        }

        $this->shared = $shared;

        return $this;
    }

    /**
     * @return mixed|null
     */
    private function getDeclaration()
    {
        return $this->declaration;
    }

    /**
     * @param $declaration
     * @return $this
     * @throws HurricaneException
     */
    private function setDeclaration($declaration)
    {
        if (!$this->isShared() && !is_callable($declaration)) {
            throw new HurricaneException('Not shared service ('. $this->getName() .') has to be declared with anonymous function!');
        }

        $this->declaration = $declaration;
        return $this;
    }

    /**
     * @return null
     */
    private function getResolvedInstance()
    {
        return $this->resolvedInstance;
    }

    /**
     * @param $resolvedInstance
     * @return ServiceLocatorElement
     */
    private function setResolvedInstance($resolvedInstance)
    {
        $this->resolvedInstance = $resolvedInstance;

        return $this;
    }

}