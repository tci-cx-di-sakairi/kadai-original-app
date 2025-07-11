<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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

    /**
     * このユーザーに関係するモデルの件数をロードする。Add commentMore actions
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount(['threads', 'comments']);
    }

    /**
     * このユーザーが所有するスレッド。（ Threadモデルとの関係を定義）
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * このユーザーが所有するコメント。（ Commentモデルとの関係を定義）
     */
    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }
}
