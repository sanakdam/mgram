<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	public function user() {
		return $this->belongsTo('App\User');
	}

	public function likes() {
		return $this->belongsToMany(User::class, 'likes');
	}

	public function isLiked() {
		return (boolean) $this->likes()->where('user_id', auth()->user()->id)->count();
	}

	public function comment() {
		return $this->hasMany('App\Comment');
	}
}