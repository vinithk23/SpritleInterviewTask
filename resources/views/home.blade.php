@extends('layouts.app')

@section('content')
    <style>
        .w-5 {
            display: none;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10 col-md-10">
                <div class="card">
                    {{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

                    <div class="card-body">
                        <div class="col-md-12">
                            @foreach($data as $post)
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <ul class="nav">
                                            <li class="nav-item bg-primary rounded-circle p-2">
                                                <span
                                                    class="text-light">{{ ($post->userDetails && $post->userDetails->name) ? getInitialForImage($post->userDetails->name) : '' }}</span>
                                            </li>
                                            <li class="nav-item m-2"><h6 class="m-0"><span class="m-0">
                                                        {{ ($post->userDetails && $post->userDetails->name) ? $post->userDetails->name : '' }}
                                                    </span>
                                                </h6></li>
                                        </ul>
                                        <div class="m-2">
                                            {!! $post->content ?? '' !!}
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-5">

                                                <p class="small">Posted {{ $post->updated_at->diffForHumans() }} </p>
                                            </div>
                                            <div class="col-6 col-md-6 d-flex">
                                                <div class="col-md-1"></div>
                                                <div class="col-6 justify-content-end d-flex">
                                                    <div class="col-6"></div>
                                                    <div class="col-6 col-md-8">
                                                        <a class="btn"><span
                                                                id="heart_{{$post->id}}"
                                                                data-value="{{ $post->canLike ?? 1 }}"
                                                                {{ (Auth()->user()) ? "onclick=heartChange(".$post->id.")" : '' }}><i
                                                                    class="justify-content-end {{ ($post->canLike == 1) ? 'fa fa-heart text-danger' : 'fa fa-heart-o' }}"
                                                                    aria-hidden="true"> {{ ($post->likeCount > 1) ? $post->likeCount.' Likes' : $post->likeCount.' Like' }}</i></span></a>
                                                    </div>

                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <a class="btn comment_{{$post->id}}"
                                                        {{ (Auth()->user()) ? "onclick=commentClick(".$post->id.")" : '' }}><span><i
                                                                class="fa fa-comment-o"
                                                                aria-hidden="true"> <span
                                                                    id="commentCountSpan_{{$post->id}}">{{ $post->commentCount ?? 0 }}</span> Comments</i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth()->user())
                                        <div id="displayComment_{{$post->id}}" class="commentHide">
                                            {{--                                            <livewire:comments :postId="$post->id" :wire:key="'item-'.$post->id">--}}
                                            {{--                                            @livewire('comments', ['postId' => $post->id])--}}
                                            @livewire('comments', ['postId' => $post->id], key('postId-'.$post->id))
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $('.commentHide').hide();

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
                            if (likeCount > 1) {
                                likeText = likeCount + ' Likes';
                            } else {
                                likeText = likeCount + ' Like';
                            }
                            likeId.data('value', 1);
                            likeId.html('<i class="fa fa-heart text-danger" aria-hidden="true"> ' + likeText + '</i>');
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
                            if (likeCount > 1) {
                                likeText = likeCount + ' Likes';
                            } else {
                                likeText = likeCount + ' Like';
                            }
                            likeId.data('value', 0);
                            likeId.html('<i class="fa fa-heart-o" aria-hidden="true"> ' + likeText + '</i>');
                        }
                    },
                    error: function (error, jqXHR, textStatus) {

                    }
                });
            }
        }


        function commentClick(id) {
            let displayComment = $("#displayComment_" +id);
            displayComment.toggle();

            if (displayComment.css('display') !== 'none') {
                $(".comment_"+ id).addClass("text-danger");
            } else {
                $(".comment_"+ id).removeClass("text-danger");
            }

        }

        // $("#commentCount").change(function (thiss) {
        //     alert('fsjcbfj');
        //     // const element = document.getElementById("currentPostView");
        //     // element.scrollIntoView();
        //     // alert("The text has been changed.");
        // });

        function commentIncrement(postId) {
            setTimeout(function () {
                $('#commentCountSpan_' + postId).text(parseInt($('.currentPostCommentCount_' + postId).val()));
            }, 1000);
        }

        @endif

    </script>
@endsection
