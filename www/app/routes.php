<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;





return function (App $app) {


    $app->get('/', function (Request $request, Response $response) {
        //return view..
        $view = \Slim\Views\Twig::create(__DIR__.'/../templates');
        return $view->render($response, 'index.php');
    });

    $app->get('/add', ['App\Controller\BackEnd\Product','add'] );


    //$app->get('/',['App\Controller\BackEnd\Product','index'] );
    //$app->get('/product',['App\Controller\BackEnd\Product','search'] );

    /*
     * $app->get('/x', function (Request $request, Response $response) {
        //curl test localhost:9200..

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'elasticsearch:9200');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        $response->getBody()->write(json_encode($result));
        //connect..




        return $response;
    });
    */


};
