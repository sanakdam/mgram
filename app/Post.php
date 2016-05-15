<?php

namespace App;
use App\Like;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	public function user() {
		return $this->belongsTo('App\User');
	}

	public function likes() {
		return $this->hasMany('App\Like');
	}

	public function is_liked() {
		$cek = Like::where('post_id', $this->id)
			->where('user_id', auth()->user()->id)->count();

		return $cek >= 1;
	}

	public function like_count() {
		return Like::where('post_id', $this->id)->count();
	}
}