<?php
require '../vendor/autoload.php';
require '../src/config/Database.php';
require '../src/config/PlayerDAO.php';
require '../src/config/UserRootDAO.php';
require '../src/config/ApplicationValidationDAO.php';
require '../src/model/Player.php';
require '../src/model/AppPermition.php';
require '../src/model/UserRoot.php';


$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);

// This Slim setting is required for the middleware to work
$app = new Slim\App([
    "settings" => [
        "determineRouteBeforeAppMiddleware" => true,
    ]
]);

// This is the middleware
// It will add the Access-Control-Allow-Methods header to every request

$app->add(function($request, $response, $next) {
    $route = $request->getAttribute("route");

    $methods = [];

    if (!empty($route)) {
        $pattern = $route->getPattern();

        foreach ($this->router->getRoutes() as $route) {
            if ($pattern === $route->getPattern()) {
                $methods = array_merge_recursive($methods, $route->getMethods());
            }
        }
        //Methods holds all of the HTTP Verbs that a particular route handles.
    } else {
        $methods[] = $request->getMethod();
    }

    $response = $next($request, $response);


    return $response->withHeader("Access-Control-Allow-Methods", implode(",", $methods));
});


require '../src/routes/route.php';

$app->run();