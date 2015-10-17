<?php

use Hurricane\Router\Route;

$router->setDefaultControllerNamespace('Application\Controllers\\')
    ->add((new Route('/', 'index', 'index'))->via(Route::GET)->via(Route::OPTIONS))
    ->add((new Route('/product', 'product', 'create'))->via(Route::POST))
    ->add((new Route('/product/{id:[0-9]+}', 'product', 'update'))->via(Route::PUT));

$router->notFound(new Route('', 'error', 'error'));