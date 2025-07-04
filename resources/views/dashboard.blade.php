@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div>
            <div class="text-center"><h2 class="text-3xl font-bold">- Let's start conversations! -</h2></div>
            {{-- 投稿フォーム --}}
            @include('threads.form')
            <div class="mt-4">
                <h2 class="text-3xl font-bold">Most Popular</h2>
                {{-- 投稿一覧 --}}
                @include('threads.threads', ['threads' => $threadsPopular])
            </div>
            <div class="mt-4">
                <h2 class="text-3xl font-bold">You Paticipated</h2>
                {{-- 投稿一覧 --}}
                @include('threads.threads', ['threads' => $threadsPaticipated])
            </div>
            <div class="mt-4">
                <h2 class="text-3xl font-bold">ALL</h2>
                {{-- 投稿一覧 --}}
                @include('threads.threads', ['threads' => $threadsAll])
            </div>
        </div>
    @else
        <div class="prose hero bg-base-200 mx-auto max-w-full rounded">
            <div class="hero-content text-center my-10">
                <div class="max-w-md mb-10">
                    <h2>Welcome to the Flash</h2>
                    {{-- ユーザー登録ページへのリンク --}}
                    <a class="btn btn-primary btn-lg normal-case" href="{{ route('register') }}">Sign up now!</a>
                </div>
            </div>
        </div>
    @endif
@endsection
