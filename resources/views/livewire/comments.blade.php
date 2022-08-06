    <div>
   <div class="card m-4 border-0">
        <form class="form-inline d-flex">
            <span class="bg-primary rounded-circle p-2 mx-3"><span class="text-light">{{ getInitialForImage(Auth::user()->name ?? 'AA') }}</span></span>
            <input
                type="text" wire:model="comment"
                class="form-control border-outline-secondary w-75">
            <button type="button" class="btn btn-primary btn-sm mx-3" onclick="commentIncrement({{ $postId }})" wire:click="addComment">Submit
            </button>
        </form>
    </div>
    <input type="hidden" class="commentCount currentPostCommentCount_{{ $postId }}" wire:model="postCommentCount" value="{{ $postCommentCount ?? 0 }}">
    @foreach($postComments as $comment)
        <div class="card border-0">
            <div class="mx-3">
                <ul class="nav">
                    <li class="nav-item bg-primary rounded-circle commentImage">
                        <span class="text-light">{{ ($comment->userDetails && $comment->userDetails->name) ? getInitialForImage($comment->userDetails->name) : '' }}</span>
                    </li>
                    <li class="nav-item m-2"><h6 class="m-0"><span
                                class="m-0 small">{{ ($comment->userDetails && $comment->userDetails->name) ? $comment->userDetails->name : '' }}</span>
                        </h6></li>
                </ul>
                <div class="m-2">
                    <p>{{ $comment->comment ?? '' }}</p>
                    <hr>
                </div>

            </div>
        </div>

    @endforeach
    </div>
