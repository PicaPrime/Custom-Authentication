<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

}
