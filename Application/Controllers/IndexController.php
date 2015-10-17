<?php

namespace Application\Controllers;

use Hurricane\Controller\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo "<pre>";
        print_r('index action in index controller');
        echo "</pre>";
    }

}