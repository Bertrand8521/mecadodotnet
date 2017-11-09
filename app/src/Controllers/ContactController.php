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
      $postDonne=$request->getParsedBody();

      $error=[];
      if(!array_key_exists('nom',$_POST)|| $_POST['nom']=='' ||  !preg_match("/[a-zA-Z0-9]+$/", $_POST['nom'])){
          $error['nom']="Vous avez rentré nom invalide ou laissé vide";
      }
      if(!array_key_exists('mail',$_POST)|| $_POST['mail']=='' || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
          $error['mail']="Vous n'avez pas rentré une adresse mail valide";
      }
      if(!array_key_exists('message',$_POST) || $_POST['message']==''){
          $error['message']="Vous n'avez pas rentré de message";
      }

        $_SESSION['errorContact']=$error;

        if( $postDonne['buttonSubmit']=="submit"){
          if(!empty($_SESSION['errorContact'])){
              $this->container->flash->addMessage("Error", "Erreur lors de l'enregistrement :");
              return $response->withRedirect("/contact");
          }

            $email_dest = "mecadodotnet@yopmail.fr";
            $nom = utf8_encode($_POST['nom']);
            $msg = utf8_encode($_POST['message']);
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
            Email : ".$email."
            -------------------------------------
            ".$msg."
            -------------------------------------";
//message 2
            $message2 = "Chèr(e) ".$nom.",
            Merci pour votre message et votre visite sur www.mecado.net,\n

            Corps du message :
            -------------------------------------
            ".$msg."
            -------------------------------------
            \n
            A très bientôt.\n";

            mail($email_dest,utf8_decode('mecado.net : message depuis le site'),utf8_decode($message),$headers);
            mail($email,utf8_decode('mecado.net : Merci pour votre message'),utf8_decode($message2),$headers2);



        return $response->withRedirect("/");
      }
    }


}
