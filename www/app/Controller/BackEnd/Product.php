<?php

namespace App\Controller\BackEnd;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Product
{
   public function index(Request $request, Response $response, $args): Response
   {
       $response->getBody()->write(json_encode(['message' => 'First Controller!']));
       return $response;
   }
}