<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\Profile;
use App\Models\Access\User\SocialLogin;
use App\Models\Article\Article;
use App\Models\Article\Comment;

/**
 * Class UserRelationship
 * @package App\Models\Access\User\Traits\Relationship
 */
trait UserRelationship
{

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.assigned_roles_table'), 'user_id', 'role_id');
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialLogin::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}