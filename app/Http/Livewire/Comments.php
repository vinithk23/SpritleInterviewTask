<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comments extends Component
{
    public $newComment;
    public $postComments;
    public $postId;
    public $comment;
    public $postCommentCount;

    public function render()
    {
        return view('livewire.comments');
    }

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->postComments = Comment::with('userDetails')->where('post_id', $this->postId)->orderByDesc('updated_at')->get();
    }

    protected $rules = [
        'comment' => 'required|string',
        'postId' => 'required|integer|exists:posts,id',
    ];

    public function addComment()
    {
        $this->validate();

        $input['comment'] = $this->comment;
        $input['post_id'] = $this->postId;
        $input['user_id'] = Auth::user()->id;
        $newComment = Comment::create($input);
        $this->postComments->push($newComment);
        $this->postCommentCount = count($this->postComments);
        $this->comment = "";
        $this->newComment = "";
    }
}
