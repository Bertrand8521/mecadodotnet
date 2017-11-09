<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;

use App\Controllers\CommentaireController;

use App\Models\Item;
use App\Models\Liste;
use App\Models\Commentaire_item;


final class ItemController extends BaseController
{

    public function getItemsFromToken(Request $request, Response $response, $args)
    {
      $liste = Liste::where('token', '=', $request->getAttribute('route')->getArgument('token'))->first();
      $items_query = Item::where('liste_id', '=', $liste->id)->get();

      $items = $items_query->toArray();
      return $this->container->view->render($response, "addItem.twig", ['items'=> $items, 'token'=>$args['token'] , 'liste' => $liste] );

    }


    public function addItem(Request $request, Response $response, $args)
    {
        $liste = Liste::where('token', '=', $args['token'])->first();
        $items_query = Item::where('liste_id', '=', $liste->id)->get();

        $items = $items_query->toArray();

        $nbCommentaires = []; // liste de nombre de commnetaires (dans le meme ordre que les listes)
        $items_query->map(function ($item) use (&$nbCommentaires) {
          $nbCommentaires[] = CommentaireController::nbCommentaireListe($item->id);
        });
        return $this->container->view->render($response, "testItem.twig", ['items' => $items, 'nbCommentaires' => $nbCommentaires, 'token' => $args['token'] ] );
    }

    public function postItem(Request $request, Response $response, $args) {
      $postDonne=$request->getParsedBody();
      $item=new Item();
      $errorAddItem=[];
      if(!array_key_exists('name',$_POST)|| $_POST['name']=='' ||  !preg_match("/[a-zA-Z]+$/", $_POST['name'])){
          $errorAddItem['name']="Vous avez pas rentré un nom d'item ou nom incorrect";
      }

      if(!array_key_exists('tarif',$_POST)|| $_POST['tarif']=='' ||  !preg_match("/[0-9]+$/", $_POST['tarif'])){
          $errorAddItem['tarif']="Vous n'avez pas rentré un tarif ou format de tarif incorrect";
      }

      if(!array_key_exists('description',$_POST)|| $_POST['description']==''){
          $errorAddItem['description']="Vous n'avez pas rentré une description de l'item";
      }

      $_SESSION['errorItem']=$errorAddItem;

      if(isset ($postDonne) && $postDonne['buttonAjoutItem']=="ajoutItem"){
          if(!empty($_SESSION['errorItem'])){
              $this->container->flash->addMessage("ErrorItem", "Votre item n'a pas été enregistré :");
              return $response->withRedirect("/item/{token}");
          }       
      
          $item->liste_id=$postDonne['liste_id'];
          $item->nom=$postDonne["name"];
          $item->tarif=$postDonne["tarif"];
          $item->description=$postDonne["description"];

          $uploads_dir =$this->container->uploads.DIRECTORY_SEPARATOR ;
          $error = $_FILES["image"]["error"] ;
          if ($error == UPLOAD_ERR_OK) {
              $tmp_name = $_FILES['image']['tmp_name'];
              $name = uniqid('img-'.date('Ymd').'-');
              move_uploaded_file($tmp_name, $uploads_dir.''.$name);
              $item->lien_image = $name;
          }

          $item->save();
          $this->container->flash->addMessage("successAddItem","L'item a été ajoutée avec succès");
          return $response->withRedirect("/item/{token}");
        }

    }

    public function deleteitem(Request $request, Response $response, $args){
      $post = $request->getParsedBody();

        $option_id = $post['delete_item_option'];
        $items = Item::find($option_id);
        $nom = $items['nom'];

          $commentaire_item = Commentaire_item::where('item_id', '=', $option_id )->get()->toArray();

          $j = 0 ;//TODO pas bien :(
          foreach ($commentaire_item as $value) {//chaque commentaire de chaque item de la liste à supprimer
            $coI = $commentaire_item[$j];
            $comItem_id = $coI['id'];

            Commentaire_item::destroy($comItem_id);

            $j++;
          }

        Item::destroy($option_id);
        $test = $items['liste_id'];
        $list = Liste::where('id', '=', $test )->first();
        $token = $list->token;


        $this->container->flash->addMessage("Success", $nom." a été supprimé");
        return $response->withRedirect("/item/".$token);


    }
 }
unset($_SESSION['errorItem']);
