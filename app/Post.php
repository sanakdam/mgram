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

	public function comments() {
		return $this->hasMany('App\Comment');
	}

	public function isFollowed()
	{
		return (boolean) $this->followers()
			->where('follower_id', auth()->user()->id)->count();
	}
	public function getDashboardPostIds()
	{
		return $this->followings()->get()->pluck('id')->push($this->id);
	}
	public function followings()
	{
		return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');
	}
	public function followers()
	{
		return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');
	}
}