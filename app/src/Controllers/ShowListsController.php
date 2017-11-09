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


        $items = Item::where('liste_token', '=', $listes->nom)->get()->toArray();
        var_dump($items);
        return;

        //liste::destroy($option_id);
        
        $this->container->flash->addMessage("Success", $nom." a été supprimé");
        //return $response->withRedirect("/showlists");
    }

 }

/*
$liste = new Liste();
$liste->createur_id = $createur_id;
$liste->token = md5(time() . mt_rand());
$liste->nom = $post['name'];
$liste->description = $post['description'];
$liste->date_val = $post['date'];
$liste->destinataire = $post['check_dest'] ? Createur::where('id', '=', $createur_id)->first()['nom'] : $post['nom_dest'];
$liste->save();
