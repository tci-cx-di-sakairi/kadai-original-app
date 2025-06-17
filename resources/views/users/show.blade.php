@extends('layouts.app')

@section('content')
    <div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-10">
            <aside>
                {{-- ユーザー情報 --}}
                @include('users.card')
            </aside>
            <div class="sm:col-span-2 ">
                <div class="card-body bg-base-200 text-4xl">
                    <h2 class="card-title">{{ $user->name }}</h2>
                </div>
                <div class="m-4">{{ $title }}</div>
                <a class="btn btn-success btn-sm normal-case mr-2 text-white" href="{{ route('users.edit', $user) }}">Edit</a>
            </div>
        </div>
        <div class="mt-4">
            {{-- 投稿フォーム --}}
            @include('threads.form')
            {{-- 投稿一覧 --}}
            @include('threads.threads')
        </div>
    </div>
@endsection
