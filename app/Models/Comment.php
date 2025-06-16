<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'threads_comment';
    protected $fillable = ['content', 'user_id', 'thread_id'];

    /**
     * この投稿を所有するユーザー。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この投稿を所有するスレッド。（ Threadsモデルとの関係を定義）
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}