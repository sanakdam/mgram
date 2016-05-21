<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
	protected $table = "comments";

	protected $fillable = [
		'comment_body',
		'post_id',
		'user_id',
	];
	public function posts() {
		return $this->belongsTo('App\Post');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}
}
