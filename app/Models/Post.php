<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $appends = ['likeCount', 'canLike', 'commentCount'];
    protected $fillable = [
        'user_id',
        'content',
    ];

    public function getlikeCountAttribute()
    {
        return Like::where('post_id', $this->id)->count();
    }

    public function getcanLikeAttribute()
    {
        return Like::where('post_id', $this->id)->where('user_id', Auth()->user()->id ?? '')->count();
    }

    public function getcommentCountAttribute()
    {
        return Comment::where('post_id', $this->id)->count();
    }

    public function userDetails()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
