<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = ['pivot'];

    public function articles()
    {
        return $this->hasMany(Article::class)->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
