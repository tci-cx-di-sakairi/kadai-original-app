@if (Auth::id() == $user->id)
    <div class="mt-4">
        <form method="POST" action="{{ route('threads.store') }}">
            @csrf

            <div class="form-control mt-4">
                <textarea rows="2" name="title" class="input input-bordered w-full"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block normal-case">Post</button>
        </form>
    </div>
@endif
