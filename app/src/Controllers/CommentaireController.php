<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Models\Commentaire_liste;
use App\Models\Commentaire_item;

final class CommentaireController extends BaseController {
	public function getCommentaireItem($id) {

		return Commentaire_item::where('item_id', '=', $id)->get()->toArray();
		// $commentaireitem = Commentaire_item::where('id', '=', $args['commentaire_id'])->get()->toArray();
		// return $this->container->view->render($response, "commentaireitem.twig", [commentaireitem => $commentaireitem]);

	}

	public function getCommentaireListe($id) {

		return Commentaire_liste::where('liste_id', '=', $id)->get()->toArray();
		// $commentaireliste = Commentaire_liste::where('id', '=', $args['commentaire_id'])->get()->toArray();
		// return $this->container->view->render($response, "commentaireliste.twig", [commentaireliste => $commentaireliste]); // Probable de devoir remplacer par le fichier twig une fois qu'il sera créé

	}

	public function nbCommentaireListe($id) {

		return Commentaire_liste::where('liste_id', '=', $id)->count();
	}

	public function nbCommentaireItem($id) {

		return Commentaire_item::where('liste_id', '=', $id)->count();
	}
}