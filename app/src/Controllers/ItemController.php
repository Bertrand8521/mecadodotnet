<?php

namespace App\Controllers;

// use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// use Slim\Flash\Messages;

use App\Models\Item;


final class ItemController extends BaseController
{

    public function item(Request $request, Response $response, $args)
    {
        // $args->id
        $item = ["nom" => "test nom", "description" => "test description", "tarif" => 10];
        return $this->container->view->render($response, "testItem.twig", $item);
    }

    public function getItemsFromToken(Request $request, Response $response, $args)
    {
        $items = Item::where('liste_token', '=', $args['token'])->get()->toArray();
        return $this->container->view->render($response, "testItem.twig", [items => $items, token=>$args['token'] ] );
    }

    public function reservationItem(Request $request, Response $response, $args)
    {
        $item = Item::where('id', '=', $args['id'])->first();
        if ($item['reserve'] = 0) {
            $item['reserve'] = 1
            $item->save();
        }
    }
 }
