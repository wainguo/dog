<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = ['id'];


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopePosition($query, $position)
    {
        return $query->where('position', $position);
    }
}
