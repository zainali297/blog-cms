<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
   protected $fillable = [
    'title', 'slug', 'excerpt', 'image_path', 'body', 'status', 'published_at',
];
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
{
    return $query->where('status', 'published');
}

protected function imageUrl(): Attribute
{
    return Attribute::get(
        fn () => $this->image_path ? asset('storage/' . $this->image_path) : null
    );
}

}