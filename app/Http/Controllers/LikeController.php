<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    public function like(LikeRequest $request)
    {
        DB::beginTransaction();
        try {
            if(Like::where('post_id', $request->post_id)->where('user_id', $request->user_id)->count() == 0){
                Like::create($request->all());
            }
            $likeCount = Like::where('post_id', $request->post_id)->count();
            DB::commit();
            return response(['message' => 'Success', 'likeCount' => $likeCount]);
        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@LikeController@like - ' . $exception->getMessage());
            return response(['message' => 'fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */


    public function destroy(LikeRequest $request)
    {
        info('disLike $request');
        info($request);
        DB::beginTransaction();
        try {
            Like::where('post_id', $request->post_id)->where('user_id', $request->user_id)->delete();
            $likeCount = Like::where('post_id', $request->post_id)->count();
            DB::commit();
            return response(['message' => 'Success', 'likeCount' => $likeCount]);
        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@LikeController@destroy - ' . $exception->getMessage());
            return response(['message' => 'fail']);
        }
    }
}
