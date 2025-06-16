<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;

class CommentsController extends Controller
{
    public function store(Request $request, $id){
        // バリデーション
        $request->validate([
            'content' => 'required|max:1023',
        ]);

        $thread = Thread::findOrFail($id);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'thread_id' => $thread->id,
        ]);

        return redirect()->route('threads.show', $thread->id)->with('success', 'コメントを投稿しました。');
    }

    public function destroy($id){
        $comment = Comment::findOrFail($id);
        $userId = Auth::id();

        if($userId !== $comment->user_id && $userId !== $comment->thread->user_id){
            return back()->with('error', 'あなたにその権限はありません。');
        }

        $comment->delete();
        return back()->with('success', 'コメントの削除に成功しました。');
    }
}
