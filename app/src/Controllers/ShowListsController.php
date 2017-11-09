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
        // TODO createur_id
        $createur_id = 1;
        $listes = Liste::where('createur_id', '=', $createur_id)->get()->toArray();

        return $this->container->view->render($response, 'showlists.twig', [listes => $listes]);
    }

 }
