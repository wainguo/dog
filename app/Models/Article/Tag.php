<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected  $fillable = ['tag_name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tag', 'tag_id', 'article_id');
    }
}
