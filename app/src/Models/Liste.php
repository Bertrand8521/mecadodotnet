<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
  protected $table = "Liste";
  protected $primarykey ='id';
  public $timestamps=true;

  public function item(){
		return $this->hasMany('\App\Models\Item');  
	}

  public function createur(){
		return $this->belongsTo('\App\Models\Createur','createur_id');  
	}

}