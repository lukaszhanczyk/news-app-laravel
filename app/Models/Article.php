<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'url_to_image',
        'published_at',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class,'source_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function apiSource()
    {
        return $this->belongsTo(ApiSource::class,'api_source_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }
}
