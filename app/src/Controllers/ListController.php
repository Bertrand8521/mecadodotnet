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

    private function validate($r) {
      if (!valid($r->post('nom'), 25)) {
        return "le nom doit être rempli faire moins de 25 caractères";
      }
      if (!valid($r->post('description'), 250)) {
        return "la description doit être remplie faire moins de 500 caractères";
      }
      $date = new strtotime($r->post('date'));
      if ($date === FALSE) {
        return "date invalide";
      }
      else if ($date < time()) {
        return "date trop proche ou ancienne";
      }
      if ($r->post('check_dest') && !valid($r->post('nom'), 25)) {
        return "le nom du destinataire doit être rempli faire moins de 25 caractères";
      }
      return "ok";
    }

    public function addlist(Request $request, Response $response, $args)
    {
        if ($request->isPost()) {
          $valid = validate($request);
          if ($valid === "ok") {

          }
          else {

          }
        }
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
