<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire_liste extends Model
{
  protected $table = "Commentaire_liste";
  protected $primarykey ='id';
  public $timestamps=true;


  public function liste(){
		return $this->belongsTo('\App\Models\Liste','liste_id');  
	}

}