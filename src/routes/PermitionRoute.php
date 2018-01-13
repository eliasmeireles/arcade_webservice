<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

$app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Accept, Origin, Authorization')
        ->withHeader('Content-Type', 'application/json')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});


$app->get('/api/permition/data/{token}', function (Request $request, Response $response, array $arguments) {

    $permition = new ApplicationValidationDAO();

    $result = $permition->getPermition($arguments['token']);

    return json_encode($result);
});
