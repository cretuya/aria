<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
	protected $table = 'bandalbums';

	protected $guarded = ['album_id'];

	protected $fillable = [
		'album_name' , 
		'album_desc' , 
		'band_id' , 
	];

	public $rules = [
	'album_name' => 'required|max:50',
	'album_desc' => 'required|max:255',
	];

	public $updaterules = [
	'album_name' => 'required|max:50',
	'album_desc' => 'required|max:255',
	];

	public function band()
	{
		return $this->belongsTo('App\Band', 'band_id', 'band_id');
	}
	public function songs()
	{
		return $this->hasMany('App\Songs','album_id');
	}
}
