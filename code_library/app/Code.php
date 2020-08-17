<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
  protected $table    = 'codes';
	protected $fillable = [
	'name',
  'code',
  'explaine',
  'file',
  'bigfile',
  ];
  public function tags() {
    return $this->belongsToMany('App\Tag');
    // return $this->belongsToMany(Tag::class);
  }
}
