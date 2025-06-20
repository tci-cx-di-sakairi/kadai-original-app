<div class="mt-4">
    @if (isset($thread))
        <ul class="list-none">
            @foreach ($comments as $comment)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($comment->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザー詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $comment->created_at }}</span>
                        </div>
                        <div>
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            @if (Auth::id() == $comment->user->id)
                                <div class="col-span-1">
                                    @csrf
                                    <div class="btn btn-sm btn-gray btn-block normal-case text-black">それな：<div>{{ $comment->agree_count }}</div></div>
                                </div>
                            @else
                                {{-- フォローボタンのフォーム --}}
                                <form method="POST" action="{{ route('comments.agree', $comment) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary btn-block normal-case text-white">それな：<div>{{ $comment->agree_count }}</div></button>
                                </form>
                            @endif

                            @if (Auth::id() == $comment->user_id || Auth::id() == $thread->user_id)
                                {{-- コメント削除ボタンのフォーム --}}
                                <form method="POST" action="{{ route('comments.delete', $comment->id) }}" class="col-span-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm normal-case text-white"
                                        onclick="return confirm('Delete id = {{ $comment->id }} ?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        @if ($comments instanceof \Illuminate\Pagenation\Pagenator || $comments instanceof \Illuminate\Pagenation\LengthAwarePagenator)
            {{-- ページネーションのリンク --}}
            {{ $comments->links() }}
        @endif
    @endif
</div>
