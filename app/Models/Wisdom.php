<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisdom extends Model
{
    protected $table = 'wisdom';
    protected $guarded = ['id'];

    public function scopeNice($query)
    {
        return $query->where('grade', 0);
    }

    public function scopeGrade($query, $grade)
    {
        return $query->where('grade', $grade);
    }
}
