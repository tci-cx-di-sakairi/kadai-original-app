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

        return redirect()->route('threads.show', $thread->id)->with('success', 'The comment is pushed.');
    }

    public function destroy($id){
        $comment = Comment::findOrFail($id);
        $userId = Auth::id();

        if($userId !== $comment->user_id && $userId !== $comment->thread->user_id){
            return back()->with('Error', 'Permission error:You have no permission to delete the item.');
        }

        $comment->delete();
        return back()->with('Success', 'Delete successed');
    }

    public function agree($commentId)
    {
        $userId= auth()->user()->id;
        $comment = Comment::findOrFail($commentId);

        if ($comment->author_id == $userId) {
            logger("agree error");
            return back()->with('Error', 'You cannot agree your comment.');
        }

        $comment->incrementAgree();

        return back()->with('Success', 'You agreed the comment.');
    }
}
