<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

final class ListController extends BaseController
{
    // TODO test this
    private function valid($s, $max_len) {
      $len = strlen($s);
      return $len > 0 && $len <= $max_len;
    }

    private function validate($p) {
      if (!$this->valid($p['nom'], 25)) {
        return "le nom doit être rempli faire moins de 25 caractères";
      }
      if (!$this->valid($p['description'], 250)) {
        return "la description doit être remplie faire moins de 500 caractères";
      }
      $date = new strtotime($p['date']);
      if ($date === FALSE) {
        return "date invalide";
      }
      else if ($date < time()) {
        return "date trop proche ou ancienne";
      }
      if ($p['check_dest'] && !$this->valid($p['nom'], 25)) {
        return "le nom du destinataire doit être rempli faire moins de 25 caractères";
      }
      return "ok";
    }

    public function postList(Request $request, Response $response, $args){
      $valid = $this->validate($request->getParsedBody());
      if ($valid === "ok") {

      }
      else {



      }
      return $this->container->view->render($response, 'addlist.twig');

      $token = md5(time() . mt_rand());

      //post on serv :
      //
    }

}
