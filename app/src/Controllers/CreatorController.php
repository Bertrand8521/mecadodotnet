<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use App\Models\Createur;

final class CreatorController extends BaseController
{


    public function registerCreator(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'formRegisterCreator.twig');
    }

    public function creatorLogin(Request $request, Response $response, $args)
    {
        return $this->container->view->render($response, 'loginForm.twig');
    }

    public function registeredCreator(Request $request, Response $response, $args)
    {
        $postDonne=$request->getParsedBody();
        $creator=new Createur();

        $error=[];
        if(!array_key_exists('name',$_POST)|| $_POST['name']=='' ||  !preg_match("/[a-zA-Z]+$/", $_POST['name'])){
            $error['name']="Vous avez pas rentré un nom ou nom incorrect";
        }

        if(!array_key_exists('pseudo',$_POST)|| $_POST['pseudo']=='' ||  !preg_match("/[a-zA-Z0-9]+$/", $_POST['pseudo'])){
            $error['pseudo']="Vous n'avez pas rentré un pseudo ou pseudo incorrect";
        }

        if(!array_key_exists('email',$_POST)|| $_POST['email']=='' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error['email']="Vous n'avez pas rentré une adresse mail valide";
        }

        if(!array_key_exists('password',$_POST) || $_POST['password']==''){
            $error['password']="Vous n'avez pas rentré un mot de passe";
        }

        if(!array_key_exists('passwordConfirm',$_POST) || $_POST['passwordConfirm']==''){
            $error['passwordConfirm']="Vous n'avez pas confirmé votre mot de passe ou mots de passe non identiques";
        }

        $_SESSION['errorSignupUser']=$error;

        if(isset ($postDonne) && $postDonne['buttonSubmit']=="submit"){
            if(!empty($_SESSION['errorSignupUser'])){
                $this->container->flash->addMessage("Error", "Erreur lors de l'enregistrement :");
                return $response->withRedirect("/CreatorRegister");
            }


            $existingCreator=Createur::where("login",$postDonne["pseudo"])->first();

            if(null !== $existingCreator){
                $this->container->flash->addMessage("Erreur", "Ce compte existe déja!");
                return $response->withRedirect("/CreatorRegister");
            }

            if($postDonne["password"]!== $postDonne["passwordConfirm"]){
                $this->container->flash->addMessage("PassError","Votre mot de passe de confirmation ne correspond pas au mot de passe que vous avez rentré");
                return $response->withRedirect("/CreatorRegister");
            }

            $creator->nom=$postDonne["name"];
            $creator->login=$postDonne["pseudo"];
            $creator->email=$postDonne["email"];
            $creator->password=password_hash($postDonne["password"],PASSWORD_BCRYPT);
            $creator->save();
            $this->container->flash->addMessage("RegisterSuccss","Votre inscription a bien été enregistrée");
            return $response->withRedirect("/CreatorRegister");

        }
    }
}
unset($_SESSION['errorSignupUser']);