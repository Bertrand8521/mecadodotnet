<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use App\Models\Liste;

final class ShowListsController extends BaseController
{


    public function showlists(Request $request, Response $response, $args)
    {
        $createur_id = $_SESSION['id'];
        $listes = Liste::where('createur_id', '=', $createur_id)->get()->toArray();

        return $this->container->view->render($response, 'showlists.twig', [listes => $listes]);
    }

    public function deletelist(Request $request, Response $response, $args){
      $post = $request->getParsedBody();

        $option_id = $post['delete_list_option'];
        $listes = Liste::find($option_id);
        $nom = $listes->nom;

        $commentaire_list = Commentaire_liste::where('liste_id', '=', $option_id)->get();
        var_dump('test'); return ;
/*
        foreach ($commentaire_item as $value) {
          $id = $items->id;
          Item::destroy($id)
        }
*/




        $items = Item::where('liste_id', '=', $option_id)->get();
/*
        foreach ($items as $value) {
          $id = $items->id;
          Item::destroy($id)
        }
*/
        //Liste::destroy($option_id);
        $this->container->flash->addMessage("Success", $nom." a été supprimé");
        return $response->withRedirect("/showlists");
    }

 }
