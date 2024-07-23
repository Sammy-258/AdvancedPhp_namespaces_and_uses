<?php

use Core\Router;

$router = new Router;

$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout', 'auth');


return $router;
