<?php

namespace App\Models\Article;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function user()
    {
//        return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mall()
    {
        return $this->belongsTo(Mall::class, 'mall_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function articleMetas()
    {
//        return $this->hasMany(ArticleMeta::class);
        return $this->hasMany(ArticleMeta::class, 'article_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category', 'article_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    /*
     *  Scope article type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /*
     *  Scope article channel
     *  eg: $articles = App\Article::channel('featured')->get();
     */
    public function scopeOfChannel($query, $channelId=0)
    {
        return $query->where('channel_id', $channelId);
    }

    public function scopeBlock($query, $block=null)
    {
        return $query->where('block', $block);
    }

    /*
     *  Scope article status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
