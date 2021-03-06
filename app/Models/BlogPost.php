<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable
        = [
            'title',
            'slug',
            'category_id',
            'excerpt',
            'continent_raw',
            'is_published',
            'published_at',
            'user_id',
        ];


    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

