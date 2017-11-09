<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Createur extends Model
{
  protected $table = "Createur";
  protected $primarykey ='id';
  public $timestamps=true;

  public function liste(){
		return $this->hasMany('\App\Models\Liste');  
	}

}