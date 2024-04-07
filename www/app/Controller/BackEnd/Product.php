<?php

namespace App\Controller\BackEnd;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;




class Product
{



   public function add(Request $request, Response $response, $args): Response
   {
       //color array..
         $colors = ['red', 'green', 'blue', 'yellow', 'black', 'white', 'purple', 'pink', 'orange', 'brown'];
         $brands = ['apple', 'samsung', 'huawei', 'xiaomi', 'oppo', 'vivo', 'realme', 'oneplus', 'nokia', 'sony'];
         $series = ['iphone', 'galaxy', 'p', 'mi', 'find', 'v', 'x', 'lumia', 'xperia', 'mate'];


            //random color..


       $searchLibrary = new \App\Library\ElasticSearchLib();
       $counter = $request->getQueryParams()['counter'] ?? 0;

       $responseArray = [];

       for($i = 0; $i < $counter; $i++) {
           $rand_color = $colors[array_rand($colors)];
           $rand_brand = $brands[array_rand($brands)];
           $name = $series[array_rand($series)]." ".rand(1, 1000);
           $params = [
               'id' => rand(0,9999999), // Belge kimliği
               'body' => [
                   'name' => $name,
                   'color' => $rand_color, // Veri alanları ve değerleri
                   'brand' => $rand_brand,
                   'price' => rand(1000, 9999),
                   'stock' => rand(0, 100),
                   'created_at' => date('Y-m-d H:i:s'),
               ],
           ];
           $result = $searchLibrary->addData($params);

           $responseArray[] = $result;
       }


       echo "<pre>";
         print_r($responseArray);
            echo "</pre>";








       return $response;
   }


   public function search(Request $request, Response $response, $args): Response
   {

       $searchLibrary = new \App\Library\ElasticSearchLib();
       $result = $searchLibrary->searchData();

       echo "<pre>";
         print_r($result);
            echo "</pre>";


            $result2 = $searchLibrary->searchData(

                [ 'body' => [
                'query' => [
                    'match' => [
                        'name' => 'Mİ'

                    ]
                ]
            ]]);

            echo "<pre>";
            print_r($result2);
            echo "</pre>";


            return $response;




   }




}