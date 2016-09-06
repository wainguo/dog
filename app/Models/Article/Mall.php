<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    public function articles()
    {
        return $this->hasMany(Article::class, 'mall_id');
    }
}
