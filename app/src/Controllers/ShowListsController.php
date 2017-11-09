<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use App\Models\Liste;

use App\Controllers\CommentaireController;

final class ShowListsController extends BaseController
{


    public function showlists(Request $request, Response $response, $args)
    {
        $createur_id = $_SESSION['id'];
        $listes_query = Liste::where('createur_id', '=', $createur_id)->get();

        $listes = $listes_query->toArray();

        $nbCommentaires = []; // liste de nombre de commnetaires (dans le meme ordre que les listes)
        $listes_query->map(function ($liste) use (&$nbCommentaires) {
          $nbCommentaires[] = CommentaireController::nbCommentaireListe($liste->id);
        });
        return $this->container->view->render($response, 'showlists.twig', ['listes' => $listes, 'nbCommentaires' => $nbCommentaires]);
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
