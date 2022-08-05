@extends('layouts.app')

@section('content')
    <style>
        .w-5 {
            display: none;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

                    <div class="card-body">
                        <div class="col-md-12">
                            @foreach($data as $post)
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <ul class="nav">
                                            <li class="nav-item bg-primary rounded-circle p-2">
                                                <span>{{ ($post->userDetails && $post->userDetails[0]->name) ? getInitialForImage($post->userDetails[0]->name) : '' }}</span>
                                            </li>
                                            <li class="nav-item m-2"><h6 class="m-0"><span class="m-0">
                                                        {{ ($post->userDetails && $post->userDetails[0]->name) ? $post->userDetails[0]->name : '' }}
                                                    </span>
                                                </h6></li>
                                        </ul>
                                        <div class="m-2">
                                            {!! $post->content ?? '' !!}
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <p class="small">Posted {{ $post->updated_at->diffForHumans() }} </p>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="nav" style="float: right;">
                                                    <li class="nav-item mx-3"><a class="btn"><span
                                                                id="heart_{{$post->id}}"
                                                                data-value="{{ $post->canLike ?? 1 }}"
                                                                {{ (Auth()->user()) ? "onclick=heartChange(".$post->id.")" : '' }}><i
                                                                    class="{{ ($post->canLike == 1) ? 'fa fa-heart text-danger' : 'fa fa-heart-o' }}"
                                                                    aria-hidden="true">{{ ($post->likeCount > 1) ? $post->likeCount.' Likes' : $post->likeCount.' Like' }}</i></span></a>
                                                    </li>
                                                    <li class="nav-item"><a class="btn comment_{{$post->id}}"
                                                            {{ (Auth()->user()) ? "onclick=commentClick(".$post->id.")" : '' }}><span><i
                                                                    class="fa fa-comment-o"
                                                                    aria-hidden="true"> Comments</i></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="displayComment_{{$post->id}}">
                                        <div class="card m-4 border-0">
                                            <form class="form-inline d-flex flex-wrap"><span
                                                    class="bg-primary rounded-circle p-2 mx-3"><span>{{ getInitialForImage(Auth::user()->name ?? 'AA') }}</span></span><input
                                                    type="text"
                                                    class="form-control border-outline-secondary  w-75">
                                                <button type="submit" class="btn btn-primary btn-sm mx-3">Submit
                                                </button>
                                            </form>
                                        </div>
                                        @foreach($post->comments as $comment)
                                            <div class="card border-0">
                                                <div class="mx-3">
                                                    <ul class="nav">
                                                        <li class="nav-item bg-primary rounded-circle p-2">
                                                            <span>{{ ($comment->userDetails && $comment->userDetails[0]->name) ? getInitialForImage($comment->userDetails[0]->name) : '' }}</span>
                                                        </li>
                                                        <li class="nav-item m-2"><h6 class="m-0"><span
                                                                    class="m-0">{{ ($comment->userDetails && $comment->userDetails[0]->name) ? getInitialForImage($comment->userDetails[0]->name) : '' }}</span>
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
                                </div>
                            @endforeach
                            <span>
                                {{ $data->links() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        @if(Auth()->user())
        function heartChange(id) {
            let likeId = $("#heart_" + id);
            if (likeId.data('value') === 0) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('like') }}',
                    data: {
                        user_id: {{ Auth()->user()->id }},
                        post_id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            let likeCount = response.likeCount;
                            var likeText = '';
                            if(likeCount > 1){
                                likeText = likeCount +' Likes';
                            } else {
                                likeText = likeCount +' Like';
                            }
                            likeId.data('value', 1);
                            likeId.html('<i class="fa fa-heart text-danger" aria-hidden="true">'+likeText+'</i>');
                        }
                    },
                    error: function (error, jqXHR, textStatus) {

                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: '{{ route('disLike') }}',
                    data: {
                        user_id: {{ Auth()->user()->id }},
                        post_id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            let likeCount = response.likeCount;
                            var likeText = '';
                            if(likeCount > 1){
                                likeText = likeCount +' Likes';
                            } else {
                                likeText = likeCount +' Like';
                            }
                            likeId.data('value', 0);
                            likeId.html('<i class="fa fa-heart-o" aria-hidden="true">'+likeText+'</i>');
                        }
                    },
                    error: function (error, jqXHR, textStatus) {

                    }
                });
            }
        }


        function commentClick(id) {
            $("#displayComment_" + id).toggle();
        }

        
        @endif

    </script>
@endsection
