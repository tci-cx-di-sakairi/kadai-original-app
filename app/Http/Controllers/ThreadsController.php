<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザーを取得
            $user = \Auth::user();
            // ユーザーの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザーのスレッドも取得するように変更しますが、現時点ではこのユーザーのスレッドのみ取得します）
            $threads = $user->threads()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'threads' => $threads,
            ];
        }

        // dashboardビューでそれらを表示
        return view('dashboard', $data);
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
        ]);

        // 認証済みユーザー（閲覧者）のスレッドとして作成（リクエストされた値をもとに作成）
        $request->user()->threads()->create([
            'title' => $request->title,
        ]);

        // 前のURLへリダイレクトさせる
        return back();
    }

    public function destroy(string $id)
    {
        // idの値で投稿を検索して取得
        $thread = Thread::findOrFail($id);

        // 認証済みユーザー（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $thread->user_id) {
            $thread->delete();
            return back()
                ->with('success','Delete Successful');
        }

        // 前のURLへリダイレクトさせる
        return back()
            ->with('Delete Failed');
    }
}
