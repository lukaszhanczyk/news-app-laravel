<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'categories',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function apiSources()
    {
        return $this->belongsToMany(ApiSource::class, 'user_api_source')->withTimestamps();
    }

    public function sources()
    {
        return $this->belongsToMany(Source::class, 'user_source')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_category')->withTimestamps();
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'user_author')->withTimestamps();
    }
}
