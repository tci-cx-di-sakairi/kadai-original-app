@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('users.update', $user->id) }}">
      @csrf
      @method('PUT')

      <div>
          <label for="name">氏名</label>
          <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required autofocus autocomplete="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
          <input type="hidden" name="email" value="{{ $user->email }}">
      </div>

      <div>
          <button type="submit" class="btn btn-success btn-sm normal-case mr-2 text-white">更新</button>
      </div>

      @if ($errors->any())
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      @endif
  </form>
@endsection
