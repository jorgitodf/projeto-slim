<?php

use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../bootstrap.php';

/*
$app->get('/', function(Request $request, Response $response, array $args) {
    echo '<pre>';
    print_r($response);exit;
}); */

$app->get('/', 'App\Controllers\HomeController:index');
$app->post('/home/store', 'App\Controllers\HomeController:store');
$app->get('/home/posts', 'App\Controllers\HomeController:posts');
$app->get('/cadastro', 'App\Controllers\HomeController:new');
$app->post('/cadastro', 'App\Controllers\HomeController:create');

$app->run();