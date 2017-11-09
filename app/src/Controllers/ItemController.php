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

    public function deleteitem(Request $request, Response $response, $args){
      $post = $request->getParsedBody();

        $option_id = $post['delete_item_option'];
        $items = Item::find($option_id);
        $nom = $items->nom;
        //liste::destroy($option_id);

        $this->container->flash->addMessage("Success", $nom." a été supprimer");
      //  return $response->withRedirect("/showlists");


    }
 }
