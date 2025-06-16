@extends('layouts.app')

@section('content')
    <div>

        {{-- タイトル --}}
        <h2>{{ $thread->title }}</h2>
        {{-- コメント投稿フォーム --}}
        @include('comments.form')
        {{-- 投稿一覧 --}}
        @include('comments.comments')

    </div>
@endsection
