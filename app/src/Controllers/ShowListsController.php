<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use App\Models\Liste;
use App\Models\Item;
use App\Models\Commentaire_liste;
use App\Models\Commentaire_item;

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

        $commentaire_list =  Commentaire_liste::where('liste_id', '=', $option_id)->get();

        $i = 0 ;//TODO pas bien :(
        foreach ($commentaire_list as $value) {//chaque commentaire de la liste à supprimer
          $coL = $commentaire_list[$i] ;
          $comList_id = $coL['id'];

          Commentaire_liste::destroy($comList_id);
          $i++;
        }

        $item = Item::where('liste_id', '=', $option_id)->get()->toArray();


        $n = 0;//TODO pas bien :(
        foreach ($item as $value) { //chaque item de la liste à supprimer
          $it = $item[$n] ;
          $item_id = $it['id'];

          $commentaire_item = Commentaire_item::where('item_id', '=', $item_id )->get()->toArray();

          $j = 0 ;//TODO pas bien :(
          foreach ($commentaire_item as $value) {//chaque commentaire de chaque item de la liste à supprimer
            $coI = $commentaire_item[$j];
            $comItem_id = $coI['id'];

            Commentaire_item::destroy($comItem_id);

            $j++;
          }


          Item::destroy($item_id);
          $n++;
        }



        Liste::destroy($option_id);
        $this->container->flash->addMessage("Success", $nom." a été supprimé");
        return $response->withRedirect("/showlists");
    }

 }
