<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    /**
     * このスレッドを所有するユーザー。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このスレッドに所属するコメント。（ Commentモデルとの関係を定義）
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
