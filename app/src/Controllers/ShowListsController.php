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

 }
