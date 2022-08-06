@extends('layouts.app')

@section('content')
    <!--Include the JS & CSS-->
    <link rel="stylesheet" href="{{ url('richtexteditor/rte_theme_default.css') }}" />
    <script type="text/javascript" src="{{ url('richtexteditor/rte.js') }}"></script>
    <script type="text/javascript" src='{{ url('richtexteditor/plugins/all_plugins.js') }}'></script>
    <style>
        body{
            background: rgb(2,0,36);
            background: linear-gradient(148deg, rgba(2,0,36,1) 0%, rgba(159,92,190,1) 56%, rgba(0,212,255,1) 100%);
        }
    </style>
<div class="container" style="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">

                        <div class="col-md-12 titles text-center bg-emp-title p-2">
                            <h6>What I did interesting today</h6>
                            <form id="createPostForm" autocomplete="off" method="POST" class="form-validate"
                                  action="{{  $post ? route('post.update',  $post->id) : route('post.store') }}">
                            @csrf
                            @if( $post) @method('PUT') @endif

                                <input type="hidden" name="content" id="content" value="">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-12">
                                        <div id="div_editor1" class="mt-3" style="min-width: auto;">
                                            {!!  $post ? ($post->content ?? '') : '' !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <button type="submit" class="btn btn-success">Post</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        var editor1 = new RichTextEditor(document.getElementById("div_editor1"));
        editor1.attachEvent("change", function () {
            document.getElementById("content").value = editor1.getHTMLCode();
        });

        // setTimeout(function(){
        //     $("<rte-bottom rte-powerby>").removeAttr("style");
        // }, 2000);
        function formSubmit(){
            $('#createPostForm').submit();
        }
    </script>
@endsection
