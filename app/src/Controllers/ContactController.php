<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

final class ContactController extends BaseController
{


    public function contact(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'contact.twig');
    }

    public function sendmail(Request $request, Response $response, $args)
    {
      return $this->container->view->render($response, 'home.twig');


      if ((isset($_POST['prenom'])) && (isset($_POST['mail'])) && (isset($_POST['nom'])) && (isset($_POST['message']))  ) {
      // si les 3 variables ne sont pas vides, et si l'adresse E-mail est valide, alors, et seulement dans ce cas, on fera notre insertion dans la base
        if ((!empty($_POST['prenom'])) && (!empty($_POST['mail'])) && (!empty($_POST['nom'])) && (!empty($_POST['message']))  ) {
          // on verifie le format de l'adresse E-mail saisie
          $test_mail =  preg_match('/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)+$/', $_POST['email']);


          if ($test_mail){

            $email_dest = "mecadodotnet@yopmail.fr";
            $prenom = utf8_encode($_POST['prenom']);
            $nom = utf8_encode($_POST['nom']);
            $msg = utf8_encode($_POST['message']);
            //$tel = $_POST['tel'];
            $email = $_POST['mail'];



            $headers = 'From: <'.$email.'>'."\n";
            $headers .= 'Return-Path: <'.$email.'>'."\n";
            $headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
            $headers .='Content-Transfer-Encoding: 8bit';

            $headers2 = 'From: "mecado.net"<'.$email_dest.'>'."\n";
            $headers2 .= 'Return-Path: '.$email_dest.''."\n";
            $headers2 .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
            $headers2 .='Content-Transfer-Encoding: 8bit';

//message 1
            $message = "Message depuis le site mecado.net :\n
            Nom : ".$nom."
            Prénom : ".$prenom."
            Email : ".$email."
            -------------------------------------
            ".$msg."
            -------------------------------------";
//message 2
            $message2 = "Chèr(e) ".$prenom." ".$nom.",
            Merci pour votre message et votre visite sur www.mecado.net,\n

            Corps du message :
            -------------------------------------
            ".$msg."
            -------------------------------------
            \n
            A très bientôt.\n";

            mail($email_dest,utf8_decode('ccMirecourtDompaire : message depuis le site'),utf8_decode($message),$headers);
            mail($email,utf8_decode('ccMirecourtDompaire.fr : Merci pour votre message'),utf8_decode($message2),$headers2);

          }
        }
      }
      //return $this->container->view->render($response, 'home.twig');
    }


}
