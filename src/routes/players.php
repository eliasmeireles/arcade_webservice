<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new Slim\App([
    "settings"  => [
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

$app->get('/api/player/list/data', function (Request $request, Response $response, array $args) {

    $playerSQL = new PlayerDAO();

    $players = $playerSQL->getPlayers();

    echo $players;
});

$app->get('/api/player/data/{id}', function (Request $request, Response $response, array $args) {

    $playerDAO = new PlayerDAO();

    $players = $playerDAO->getPlayer($args['id']);

    echo $players;
});

$app->post('/api/player/savenew', function (Request $request, Response $response) {

    $playerParans = $request->getParsedBody();

    $player = new Player();
    $player->setNome($playerParans['nome']);
    $player->setPontos($playerParans['pontos']);


    $playerSQL = new PlayerDAO();

    if($playerSQL->newPlayer($player)) {
        echo true;
    };

});

$app->put('/api/player/update', function (Request $request, Response $response) {

    $playerParans = $request->getParsedBody();

    $player = new Player();
    $player->setId($playerParans['id']);
    $player->setNome($playerParans['nome']);
    $player->setPontos($playerParans['pontos']);


    $playerSQL = new PlayerDAO();

    if ($playerSQL->updatePlayer($player)) {
        echo 'Dados do usúario atualizados com sucesso!';
    };

});


$app->patch('/api/player/delete/{id}', function (Request $request, Response $response,  array $args) {

    $player = new Player();
    $player->setId($args['id']);

    $playerSQL = new PlayerDAO();

    if ($playerSQL->delete($player)) {
        echo 'Usúario removido com sucesso!';
    };

});