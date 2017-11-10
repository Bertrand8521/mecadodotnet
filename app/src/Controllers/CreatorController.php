<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use App\Models\Createur;
use App\Models\Liste;

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

        if(!array_key_exists('pseudo',$_POST)|| $_POST['pseudo']=='' ||  !preg_match("/[-a-zA-Z0-9_]+$/", $_POST['pseudo'])){
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


            $existingCreator=Createur::where("login",$postDonne["pseudo"])->orWhere("email", $postDonne["email"])->first();

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
            $creator->password=password_hash($postDonne["password"], PASSWORD_DEFAULT);
            $creator->save();
            $this->container->flash->addMessage("RegisterSuccss","Votre inscription a bien été enregistrée");
            return $response->withRedirect("/CreatorRegister");

        }
    }

     public function creatorLogged(Request $request, Response $response, $args)
    {
        $postDonne=$request->getParsedBody();
        $errorsLogin=[];

         if(!array_key_exists('pseudo',$_POST)|| $_POST['pseudo']=='' ||  !preg_match("/[a-zA-Z0-9]+$/", $_POST['pseudo'])){
            $errorsLogin['pseudo']="Vous n'avez pas rentré un pseudo ou pseudo incorrecte ";
        }

        if(!array_key_exists('password',$_POST) || $_POST['password']==''){
            $errorsLogin['password']="Vous n'avez pas rentré un mot de passe ou mot de passe incorrecte";
        }

        $_SESSION['errorLoginCreator']=$errorsLogin;

            if(isset ($postDonne) && $postDonne["buttonConnect"]=="connect"){
            	if(!empty($_SESSION['errorLoginCreator'])){
                	$this->container->flash->addMessage("ErrorLogin", "Erreur :");
                	return $response->withRedirect("/CreatorLogin");
           		}

                $password=$postDonne ["password"];
                $creator=Createur::where("login",$postDonne["pseudo"])->first();

                if (null === $creator){
                    $this->container->flash->addMessage("ErrorPseudo","Votre pseudo est incorrecte");
                    return $response->withRedirect("/CreatorLogin");
            }

            $pass=$creator->password;

            if (password_verify($password, $pass)){
                if(isset($postDonne["remember"])){
                    $token= $this->randomString(20);
                    setcookie("remember",$token,time()+60*60,"/");
                    $creator->token=$token;
                    $creator->save();

                }

                $_SESSION['isConnected'] = $creator;
                $_SESSION['id'] = $creator->id;

                $this->container->flash->addMessage("InfoSuccess","Connexion réussie");
                return $response->withRedirect("/");
            }else{
                $this->container->flash->addMessage("ErreurPassLog","Votre mot de passe est incorrecte");
                return $response->withRedirect("/CreatorLogin");
            }

        }

    }

     public function creatorLogOut(Request $request, Response $response, $args){
       if($_SESSION['isConnected']!= NULL){
        unset($_SESSION['isConnected']);
        unset($_SESSION['id']);
        setcookie("remember",null,-1,"/");
        $this->container->flash->addMessage("InfoDeconnected","Vous avez été déconnecté");

      }

        return $response->withRedirect("/");


    }


    public function removeCreator(Request $request, Response $response, $args){
      if($_SESSION['isConnected']!= NULL){
        $lists=Liste::where('createur_id', '=', $_SESSION['isConnected']['id'])->get()->toArray();
        foreach ($lists as $l) {
            ShowListsController::functionDeleteList($l);
        }

        $creator=$_SESSION['isConnected']['id'];
        Createur::destroy($creator);
        unset($_SESSION['isConnected']);
        setcookie("remember",null,-1,"/");
        $this->container->flash->addMessage("SuccèssRemoveCreator","Votre compte a été supprimé avec succès");

       }
       return $response->withRedirect("/");
    }

    // method generates a random string for tocken
    function randomString($length) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
unset($_SESSION['errorSignupUser']);
unset($_SESSION['errorLoginCreator']);
