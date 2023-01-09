<?php

namespace App\Models;

use Src\Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Src\Support\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home',
    ];

    protected function thumbnailDir(): string
    {
        return 'categories';
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
