<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleMeta extends Model
{
    //


    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
