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

$app->get('/api/player/list/data', function (Request $request, Response $response, $arguments) {

    try {

        $playerSQL = new PlayerDAO();

        $players = $playerSQL->getPlayers();

        if ($players && $players != null) {
            return $response
                ->withStatus(200)
                ->write($players);
        } else {
            throw new PDOException('Nothing could be found');
        }
    } catch (PDOException $e) {
        return writeError($response, $e, 400);
    }
});

$app->get('/api/player/data/{id}', function (Request $request, Response $response, $arguments) {


    try {

        $playerDAO = new PlayerDAO();

        $player = $playerDAO->getPlayer($arguments['id']);

        if ($player && $player != null) {
            return $response
                ->withStatus(200)
                ->write($player);
        } else {
            throw new PDOException('Nothing could be found');
        }
        echo $player;
    } catch (PDOException $e) {
        return writeError($response, $e, 404);
    }
});

$app->post('/api/player/savenew', function (Request $request, Response $response, $arguments) {

    try {

        $playerParans = $request->getParsedBody();

        $player = new Player();
        $player->setNome($playerParans['nome']);
        $player->setPontos($playerParans['pontos']);


        $playerSQL = new PlayerDAO();

        if ($playerSQL->newPlayer($player)) {
            return $response
                ->withStatus(201)
                ->write(true);
        } else {
            throw new PDOException('Could not be created');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->put('/api/player/update', function (Request $request, Response $response) {


    try {

        $playerParans = $request->getParsedBody();

        $player = new Player();
        $player->setId($playerParans['id']);
        $player->setNome($playerParans['nome']);
        $player->setPontos($playerParans['pontos']);


        $playerSQL = new PlayerDAO();

        if ($playerSQL->updatePlayer($player)) {
            return $response
                ->withStatus(201)
                ->write(true);
        } else {
            throw new PDOException('Could not be created');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }
});


$app->patch('/api/player/delete/{id}', function (Request $request, Response $response, array $arguments) {

    try {

        $player = new Player();
        $player->setId($arguments['id']);

        $playerSQL = new PlayerDAO();

        if ($playerSQL->delete($player)) {
            return $response
                ->withStatus(200)
                ->write(true);
        } else {
            throw new PDOException('Internal server error');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->get('/api/permition/data/{token}', function (Request $request, Response $response, array $arguments) {

    try {

        $permition = new ApplicationValidation();

        $result = $permition->getPermition($arguments['token']);

        if ($result && $result != null) {
            return $response
                ->withStatus(200)
                ->write($result);
        } else {
            throw new PDOException('Internal server error');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});


/**
 * @param Response $response
 * @param $e
 * @return mixed
 */
function writeError(Response $response, $e, $statusCode)
{
    $err = '{"error": {"text": "' . $e->getMessage() . '"}}';
    return $response->withStatus($statusCode)
        ->write($err);
}
