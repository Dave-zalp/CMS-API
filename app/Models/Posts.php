<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'categories_id',
        'title',
        'content',
        'published',
    ];

    public function Categories() :BelongsTo
    {
       return $this->belongsTo(Categories::class);
    }
}
