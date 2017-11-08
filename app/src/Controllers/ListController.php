<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

use App\Models\Liste;
use App\Models\Createur;

final class ListController extends BaseController
{
    private function valid($s, $max_len) {
      $len = strlen($s);
      return $len > 0 && $len <= $max_len;
    }

    private function validate($p) {
      if (!$this->valid($p['name'], 25)) {
        return "le nom doit être rempli et faire moins de 25 caractères";
      }
      if (!$this->valid($p['description'], 250)) {
        return "la description doit être remplie et faire moins de 500 caractères";
      }
      $date = strtotime($p['date']);
      if ($date === FALSE) {
        return "date invalide";
      }
      else if ($date < time()) {
        return "date trop proche ou ancienne";
      }
      if (!$p['check_dest'] && !$this->valid($p['nom_dest'], 25)) {
        return "le nom du destinataire doit être rempli et faire moins de 25 caractères";
      }
      return "ok";
    }

    public function addlist(Request $request, Response $response, $args){
      return $this->container->view->render($response, 'addlist.twig');
    }

    public function postList(Request $request, Response $response, $args){
      $post = $request->getParsedBody();
      $valid = $this->validate($post);
      if ($valid === "ok") {
        $createur_id = 1; // TODO get user id from auth

        $liste = new Liste();
        $liste->createur_id = $createur_id;
        $liste->token = md5(time() . mt_rand());
        $liste->nom = $post['name'];
        $liste->description = $post['description'];
        $liste->date_val = $post['date'];
        $liste->destinataire = $post['check_dest'] ? Createur::where('id', '=', $createur_id)->first()['nom'] : $post['nom_dest'];
        $liste->save();
        $this->container->flash->addMessage("Success", "Votre liste a bien été crée");
        return $response->withRedirect("/showlists");
      }
      else {
        $this->container->flash->addMessage("Error", $valid);
        return $this->container->view->render($response, 'addlist.twig');
      }
    }

}
