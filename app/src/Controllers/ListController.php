<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

final class ListController extends BaseController
{


    public function addlist(Request $request, Response $response, $args)
    {

        return $this->container->view->render($response, 'addlist.twig');
    }

    public function postList(Request $request, Response $response, $args){
      $name        = $_POST['name'];
      $description = $_POST['description'];
      $date        = $_POST['date'];
      if( $_POST['check_dest']) {
        $destinataire = "test" ; //nom du créateur
      }else{
        $destinataire = $_POST['check_dest'];
      }

      $token = md5(time() . mt_rand());

      //post on serv :
      //
    }

}
