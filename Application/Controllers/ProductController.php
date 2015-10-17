<?php

namespace Application\Controllers;

use Hurricane\Controller\Controller;

class ProductController extends Controller
{

    public function createAction()
    {
        echo "<pre>";
        print_r($this->getServiceLocator()->get('request')->getAll());
        echo "</pre>";
    }

    public function updateAction()
    {
        echo "<pre>";
        print_r($this->getServiceLocator()->get('request')->getAll());
        echo "</pre>";

        echo "<pre>";
        print_r($this->getServiceLocator()->get('router')->getRouterParams());
        echo "</pre>";

    }

}