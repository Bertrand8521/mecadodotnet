<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire_item extends Model
{
  protected $table = "Commentaire_item";
  protected $primarykey ='id';
  public $timestamps=true;


  public function item(){
		return $this->belongsTo('\App\Models\Item','item_id');  
	}

}