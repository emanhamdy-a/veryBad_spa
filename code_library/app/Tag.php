<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
  protected $table    = 'tags';
	protected $fillable = [
	'name',
  'parent',
  ];

  public function codes() {
      return $this->hasMany('App\Code');
  }
}
