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

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/api/v1/player/list/data', function (Request $request, Response $response, $arguments) {

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

$app->get('/api/v1/player/data/{id}', function (Request $request, Response $response, $arguments) {


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

$app->post('/api/v1/player/new', function (Request $request, Response $response, $arguments) {

    try {
        date_default_timezone_set("America/Brasilia");

        $playerParans = $request->getParsedBody();

        $player = new Player();
        $player->setNome($playerParans['nome']);
        $player->setPontos($playerParans['pontos']);
        $player->setData(date('Y-m-d'));


        $playerSQL = new PlayerDAO();

        $result = $playerSQL->newPlayer($player);
        if ($result && $result != null) {
            return $response
                ->withStatus(201)
                ->write($result);
        } else {
            throw new PDOException('Could not be created');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->put('/api/v1/player/update', function (Request $request, Response $response) {


    try {

        $playerParans = $request->getParsedBody();

        $player = new Player();
        $player->setId($playerParans['id']);
        $player->setNome($playerParans['nome']);
        $player->setPontos($playerParans['pontos']);


        $playerSQL = new PlayerDAO();

        $updatePlayer = $playerSQL->updatePlayer($player);
        if ($updatePlayer && $updatePlayer != null) {
            return $response
                ->withStatus(201)
                ->write($updatePlayer);
        } else {
            throw new PDOException('Could not be created');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }
});


$app->delete('/api/v1/player/delete/{id}', function (Request $request, Response $response, array $arguments) {

    try {

        $player = new Player();
        $player->setId($arguments['id']);

        $playerSQL = new PlayerDAO();

        if ($playerSQL->delete($player)) {
            return $response
                ->withStatus(200);
        } else {
            throw new PDOException('Internal server error');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->get('/api/v1/permition/data/{validtoken}', function (Request $request, Response $response, array  $arguments) {


    try {

        $permition = new ApplicationValidationDAO();

        $result = $permition->getPermition($arguments['validtoken']);

        if ($result && $result != null) {
            return $response
                ->withStatus(200)
                ->write(json_encode($result));
        } else {
            throw new PDOException('Invalid application token');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});


$app->post('/api/v1/userroot/new', function (Request $request, Response $response, array $arguments) {

    try {


        $userRootParams = $request->getParsedBody();

        $userRoot = new UserRoot();
        $userRoot->setEmail($userRootParams['email']);
        $userRoot->setSenha(password_hash($userRootParams['senha'], PASSWORD_DEFAULT));


        $userRootDAO = new UserRootDAO();

        $userRootResult = $userRootDAO->newRootUser($userRoot);

        if ($userRootResult && $userRootResult != null) {
            return $response
                ->withStatus(201)
                ->write(json_encode($userRootResult));
        } else {
            throw new PDOException('Could not be created');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->post('/api/v1/userroot/update', function (Request $request, Response $response, array $arguments) {

    try {

        $userRootParams = $request->getParsedBody();

        $userRoot = new UserRoot();
        $userRoot->setId($userRootParams['id']);
        $userRoot->setEmail($userRootParams['email']);
        $userRoot->setSenha(password_hash($userRootParams['senha'], PASSWORD_DEFAULT));


        $userRootDAO = new UserRootDAO();

        $userRootResult = $userRootDAO->updateUserRoot($userRoot);

        if ($userRootResult && $userRootResult != null) {
            return $response
                ->withStatus(201)
                ->write(json_encode($userRootResult));
        } else {
            throw new PDOException('Could not be created');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->post('/api/v1/userroot/get', function (Request $request, Response $response, array $arguments) {

    try {

        $userRootParams = $request->getParsedBody();

        $userRoot = new UserRoot();
        $userRoot->setEmail($userRootParams['email']);
        $userRoot->setSenha($userRootParams['senha']);

        $userRootDAO = new UserRootDAO();

        $userRootResult = $userRootDAO->getUserRoot($userRoot);


        if ($userRootResult && $userRootResult != null) {
            $decode = json_encode($userRootResult);


            $decode = json_decode($decode);

            if (password_verify($userRoot->getSenha(), $decode->senha)) {
                return $response
                    ->withStatus(200)
                    ->write(json_encode($userRootResult));
            } else {
                throw new PDOException('No user found');
            }
        } else {
            throw new PDOException('No user found');
        }

    } catch (PDOException $exception) {
        return writeError($response, $exception, 400);
    }

});

$app->delete('/api/v1/userroot/delete/{id}/{token}', function (Request $request, Response $response, array $arguments) {

    try {
        $token = json_encode($arguments['token']);
        $id = json_encode($arguments['id']);

        $permition = new ApplicationValidationDAO();
        $result = $permition->getPermition($token);


        if ($result && $result != null) {
            $userRoot = new UserRoot();
            $userRoot->setId($id);


            $userRootDAO = new UserRootDAO();

            $userRootDAO->deleteUserRoot($userRoot);

            return $response
                ->withStatus(200);
        } else {
            throw new PDOException('Access dinied');
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
