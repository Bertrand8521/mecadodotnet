<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

final class ShowListsController extends BaseController
{


    public function showlists(Request $request, Response $response, $args)
    {

        return $this->container->view->render($response, 'showlists.twig');
    }

 }
