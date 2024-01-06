<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSource extends Model
{
    use HasFactory, HasFactory;

    protected $fillable = [
        'name',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
