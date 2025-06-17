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

            //全スレッド
            $threadsAll = Thread::where('created_at', '>=', now()->subDay())->orderBy('created_at', 'desc')->paginate(15);

            //直近参加したスレッド3件
            $threadsPaticipated = Thread::whereIn('id', function($query){
                $query  ->select('thread_id')
                        ->from('threads_comment')
                        ->where('user_id', \Auth::user()->id)
                        ->orderBy('created_at', 'desc');
            })
            ->where('created_at', '>=', now()->subDay())
            ->distinct()
            ->limit(3)
            ->get();


            //直近6時間のコメント数が多い順に3件
            $threadsPopular = Thread::withCount(['comments' => function($query){
                $query->where('created_at', '>=', now()->subHours(6));
            }])
            ->where('created_at', '>=', now()->subDay())
            ->orderBy('comments_count', 'desc')
            ->limit(3)
            ->get();

            $data = [
                'user' => $user,
                'threadsPaticipated' => $threadsPaticipated,
                'threadsPopular' => $threadsPopular,
                'threadsAll' => $threadsAll,
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

    public function show($id){
        $thread = Thread::findOrFail($id);
        $comments = $thread->comments()->orderby('created_at', 'desc')->paginate(20);

        $data = [
            'thread' => $thread,
            'comments' => $comments,
        ];

        return view('threads.show', $data);
    }
}
