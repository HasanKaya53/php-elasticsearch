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

    $app->get('/list-all', function (Request $request, Response $response) {
        //return view..
        $view = \Slim\Views\Twig::create(__DIR__.'/../templates');

        $searchLibrary = new \App\Library\ElasticSearchLib();

        $params = [
            'body' => [
                'query' => [
                    'match_all' => new stdClass()
                ]
            ]
        ];

        $data = $searchLibrary->setSize(40)->setSort('created_at','desc')->searchData($params);



        return $view->render($response, 'list-all.php',['data' => $data]);
    });

    $app->get('/add', ['App\Controller\BackEnd\Product','add'] );

	$app->get('/search', function (Request $request, Response $response) {
		//return view..
		$name = $request->getQueryParams()['name'] ?? null;
		$type = $request->getQueryParams()['type'] ?? null;


		if(!$name){
			$params = [
				'body' => [
					'query' => [
						'match_all' => new stdClass()
					]
				]
			];
		}else{

			if($type == "by_name"){
				//by name..
				$params = [
					'body' => [
						'query' => [
							'match' => [
								'name' => $name
							]
						]
					]
				];
			}else if ($type == "by_color"){
				//by color..
				$params = [
					'body' => [
						'query' => [
							'match' => [
								'color' => $name
							]
						]
					]
				];
			}else if ($type == "by_brand"){
				//by brand..
				$params = [
					'body' => [
						'query' => [
							'match' => [
								'brand' => $name
							]
						]
					]
				];
			}else if ($type == "by_all_match"){
				//by all match..
				$params = [
					'body' => [
						'query' => [
							'multi_match' => [
								'query' => $name,
								'fields' => ['name','color','brand']
							]
						]
					]
				];
			}
		}



		$searchLibrary = new \App\Library\ElasticSearchLib();
		$data = $searchLibrary->setSize(40)->setSort('created_at','desc')->searchData($params);



		$response->getBody()->write(json_encode($data));

		return $response;
	});


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
