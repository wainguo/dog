<?php

namespace App\Models\Article;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'user_name', 'user_ip', 'article_id', 'parent_id', 'content', 'forbidden'
    ];

    public function user()
    {
//        return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function replies()
    {
//        return $this->hasMany(Article::class);
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    /*
     * Scope generic comments
     */
    public function scopeRoot($query)
    {
        return $query->where('parent_id', 0);
    }
}
