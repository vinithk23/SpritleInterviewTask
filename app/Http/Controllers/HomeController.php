<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $data = Post::with('userDetails', 'comments.userDetails')->orderByDesc('updated_at')->simplePaginate(15);
        return view('home', compact('data'));
    }
}
