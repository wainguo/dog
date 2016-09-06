<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $fillable = ['category_name', 'category_parent'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_parent', 'id');
    }

    public function scopeRoot($query)
    {
        return $query->where('category_parent', 0);
    }
}
