
<div class="mt-4">
    <form method="POST" action="{{ route('comments.store', $thread->id) }}">
        @csrf
        <div class="form-control mt-4">
            <textarea rows="2" name="content" class="input input-bordered w-full"></textarea>
        </div>
        <button type="submit" class="btn btn-accent btn-block normal-case text-white">Comment</button>
    </form>
</div>
