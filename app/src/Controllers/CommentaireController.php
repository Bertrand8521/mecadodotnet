<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Models\Commentaire_liste;
use App\Models\Commentaire_item;
use App\Models\Liste;
use App\Models\Item;

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

		return Commentaire_item::where('item_id', '=', $id)->count();
	}

	private function valid($s, $max_len) {
		$len = strlen($s);
		return $len > 0 && $len <= $max_len;
	}

	private function validateCommentItem($p) {
		if (!$this->valid($p['nom'], 25)) {
			return "le nom doit être rempli et faire moins de 25 caractères";
		}
		if (!$this->valid($p['commentaire'], 250)) {
			return "le commentaire doit être rempli et faire moins de 250 caractères";
		}
		$item = Item::where('id', '=', $p['idItem'])->first();
		if (! $item) {
			return "item non existant";
		}
		$liste = Liste::where('token', '=', $p['token'])->first();
		if (! $liste) {
			return "token invalide";
		}
		$list_of_item = Liste::where('id', '=', $item->liste_id)->first();
		if ($list_of_item->id != $liste->id) {
			// nice try, hackerman
			return "token invalide pour cet item";
		}

		return "ok";
	}

	public function postCommentItem(Request $request, Response $response, $args) {
		$post = $request->getParsedBody();
		$valid = $this->validateCommentItem($post);
		if ($valid === "ok") {
			$commentaire = new Commentaire_item();
			$commentaire->item_id = $post['idItem'];
			$commentaire->nom = $post['nom'];
			$commentaire->message = $post['commentaire'];
			$commentaire->save();
			$this->container->flash->addMessage("Success", "Votre commentaire a été ajouté");
			return $response->withRedirect("/item/" . $post['token']);
		}
		else {
			$this->container->flash->addMessage("Error", $valid);
			return $response->withRedirect("/item/" . $post['token']);
		}
	}

	private function validateCommentListe($p) {
		if (!$this->valid($p['nom'], 25)) {
			return "le nom doit être rempli et faire moins de 25 caractères";
		}
		if (!$this->valid($p['commentaire'], 250)) {
			return "le commentaire doit être rempli et faire moins de 250 caractères";
		}
		$liste = Liste::where('token', '=', $p['token'])->first();
		if (! $liste) {
			return "token invalide";
		}

		return "ok";
	}

	public function postCommentListe(Request $request, Response $response, $args) {
		$post = $request->getParsedBody();
		$valid = $this->validateCommentListe($post);
		if ($valid === "ok") {
			$commentaire = new Commentaire_liste();
			$commentaire->liste_id = Liste::where('token', '=', $post['token'])->first()['id'];
			$commentaire->nom = $post['nom'];
			$commentaire->message = $post['commentaire'];
			$commentaire->save();
			$this->container->flash->addMessage("Success", "Votre commentaire a été ajouté");
			return $response->withRedirect("/showlists");
		}
		else {
			$this->container->flash->addMessage("Error", $valid);
			return $response->withRedirect("/showlists");
		}
	}
}