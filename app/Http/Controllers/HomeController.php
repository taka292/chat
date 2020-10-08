<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comments = Comment::all()->orderBy('created_at', 'desc');
        dd($comments);
        $user = Auth::user();

        return view('home', ['name' => $user->name, 'comments' => $comments]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $comment = $request->input('comment');
        Comment::create([
            'login_id' => $user->id,
            'name' => $user->name,
            'comment' => $comment
        ]);
        return redirect()->route('home');
    }

    // public function getData()
    // {
    //     $comments = Comment::orderBy('created_at', 'desc')->get();
    //     $json = ["comments" => $comments];

    //     return response()->json($json);
    // }

    public function edit(Request $request)
    {
        $comments = Comment::find($request->id);
        // dd($comments);
        if (empty($comments)) {
            abort(404);
        }
        return view('components/edit', ['comment_form' => $comments]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        // $this->validate($request, Comment::$rules);
        // Todos Modelからデータを取得する
        $comment = Comment::find($request->id);
        // 送信されてきたフォームデータを格納する
        $comment_form = $request->all();
        unset($comment_form['_token']);


        // 該当するデータを上書きして保存する
        $comment->fill($comment_form)->save();

        // $history = new History;
        // $history->comment_id = $comment->id;
        // $history->edited_at = Carbon::now();
        // $history->save();

        return redirect('home');
    }
}
