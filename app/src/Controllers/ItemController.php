<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

use App\Controllers\CommentaireController;

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
        $items_query = Item::where('liste_token', '=', $args['token'])->get();

        $items = $items_query->toArray();

        $nbCommentaires = []; // liste de nombre de commnetaires (dans le meme ordre que les listes)
        $items_query->map(function ($item) use (&$nbCommentaires) {
          $nbCommentaires[] = CommentaireController::nbCommentaireListe($item->id);
        });
        return $this->container->view->render($response, "testItem.twig", ['items' => $items, 'nbCommentaires' => $nbCommentaires, 'token' => $args['token'] ] );
    }

 }
