<?php

use Hurricane\Dispatcher\Dispatcher;
use Hurricane\Request\Request;

$serviceLocator->setShared('dispatcher', new Dispatcher($serviceLocator));
$serviceLocator->setShared('request', new Request());