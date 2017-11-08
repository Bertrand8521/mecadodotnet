<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App/Models/Commentaire_liste.php
use App/Models/Commentaire_item.php

final class CommentaireController extends BaseController {
	public function getCommentaireItem(Request $request, Response $response, $args) {

		$commentaireitem = Commentaire_item::where('id', '=', $args['commentaire_id'])->get()->toArray();
		return $this->container->view->render($response, "commentaireitem.twig", [commentaireitem => $commentaireitem]);

	}

	public function getCommentaireListe(Request $request, Response $response, $args) {

		$commentaireliste = Commentaire_liste::where('id', '=', $args['commentaire_id'])->get()->toArray();
		return $this->container->view->render($response, "commentaireliste.twig", [commentaireliste => $commentaireliste]); // Probable de devoir remplacer par le fichier twig une fois qu'il sera créé

	}
}