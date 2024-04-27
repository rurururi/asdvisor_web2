<div>

    <section class="bg-white dark:bg-gray-900 py-2">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Comments
                    ({{$comments->count()}})</h2>
            </div>
            @auth
                @include('commentify::livewire.partials.comment-form',[
                    'method'=>'postComment',
                    'state'=>'newCommentState',
                    'inputId'=> 'comment',
                    'inputLabel'=> 'Your comment',
                    'button'=>'Post comment'
                ])
            @else
                <a class="mt-2 text-sm" href="/login">Log in to comment!</a>
            @endauth
            @if($comments->count())
                @foreach($comments as $comment)
                    <livewire:comment :$comment :key="$comment->id"/>
                @endforeach
                {{$comments->links()}}
            @else
                <p>No comments yet!</p>
            @endif
        </div>
    </section>
</div>
