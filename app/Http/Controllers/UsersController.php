<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;

class UsersController extends Controller
{
    public function index()
    {
        // ユーザー一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);

        // ユーザー一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function show($id)
    {
        // idの値でユーザーを検索して取得
        $user = User::withCount(['threads', 'comments'])->findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        $title = null;
        if($user->threads_count >= 10 && $user->comments_count >= 10) {
            $title = 'Pro User';
        } elseif ($user->threads_count >= 10) {
            $title = '話題クリエイター';
        } elseif ($user->comments_count >= 10) {
            $title = 'コメンテーター';
        } else {
            $title = 'Beginner';
        }

        // ユーザーの投稿一覧を作成日時の降順で取得
        $threads = $user->threads()->where('created_at', '>=', now()->subDay())->orderBy('created_at', 'desc')->paginate(10);

        // ユーザー詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
            'title' => $title,
            'threads' => $threads
        ]);
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        if (auth()->id() !== $user->id) {
            abort(403);
        }

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(ProfileUpdateRequest $request, $id) {
        $user = User::findOrFail($id);

        if(\Auth::id() !== $user->id){
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('users.show', $id)->with('success', 'UserName Changed');
    }
}
