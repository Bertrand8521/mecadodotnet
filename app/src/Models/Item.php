<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $table = "Item";
  protected $primarykey ='id';
  public $timestamps=true;

  public function commentaireItem(){
		return $this->hasMany('\App\Models\Commentaire_item');  
	}

  public function liste(){
		return $this->belongsTo('\App\Models\Liste','liste_id');  
	}

}