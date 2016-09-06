<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function articles()
    {
        return $this->hasMany(Article::class, 'channel_id', 'id');
    }

    public function scopeOfName($query, $name)
    {
        return $query->where('channel_name', $name);
    }
}
