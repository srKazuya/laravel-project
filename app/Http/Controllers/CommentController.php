<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;





class CommentController extends Controller
{


    public function index(){
        $comments = Comment::all();
        return view('comments.index', ['comments' => $comments]);
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);
        $comment = new Comment();
        $comment->name = $request->name;
        $comment->desc = $request->desc;
        $comment->article_id=$request->article_id;

        $comment->user_id=Auth::id();
        $comment->save();
        return redirect()->back();
      

    }
    public function edit($id){
      
        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        return view('comments.update', ['comment' => $comment]);
    }
    public function update(Request $request, Comment $comment){
        Gate::authorize('update_comment', $comment);
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);
        // $comment = Comment::findOrFail($id);
        $comment->name = $request->name;
        $comment->desc = $request->desc;
        $comment->created_at = date('d.m.Y H:i');
        $comment->save();
        return redirect()->route('article.show', $comment->article_id)->with('success', 'Комментарий отредактирован');
    }

    public function delete($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Комментарий успешно удалён.');
    }
       
}
