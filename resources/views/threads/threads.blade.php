<div class="mt-4">
    @if (isset($threads))
        <ul class="list-none grid grid-cols-3">
            @forelse ($threads as $thread)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-24 rounded">
                            <img src="{{ Gravatar::get($thread->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザー詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $thread->user->id) }}">{{ $thread->user->name }}</a>
                            <span class="text-muted text-gray-500">posted : {{ $thread->created_at }}</span>
                        </div>
                        <div>
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($thread->title)) !!}</p>
                        </div>
                        <div class="flex">
                            <a class="btn btn-success btn-sm normal-case mr-2 text-white" href="{{ route('threads.show', $thread->id) }}">View</a>

                            @if (Auth::id() == $thread->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                <form method="POST" action="{{ route('threads.destroy', $thread->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm normal-case text-white"
                                        onclick="return confirm('Delete id = {{ $thread->id }} ?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li>条件に合うスレッドはありません。</ｌ>
            @endforelse
        </ul>
        @if ($threads instanceof \Illuminate\Pagenation\Pagenator || $threads instanceof \Illuminate\Pagenation\LengthAwarePagenator)
            {{-- ページネーションのリンク --}}
            {{ $threads->links() }}
        @endif
    @endif
</div>
