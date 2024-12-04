<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCommentMail;
use App\Jobs\VeryLongJob;

class CommentController extends Controller
{


    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('comments.index', ['comments' => $comments]);
    }


    public function store(Request $request)
    {
        $article = Article::findOrFail($request->article_id);
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);
        $comment = new Comment();
        $comment->name = $request->name;
        $comment->desc = $request->desc;
        $comment->article_id = $request->article_id;

        $comment->user_id = Auth::id();
        if ($comment->save()) {
            VeryLongJob::dispatch($comment, $article->name);
            return redirect()->back()->with('status', 'Комментарий отправлен на модерацию');
        }
        
    }
    public function edit($id)
    {

        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        return view('comments.update', ['comment' => $comment]);
    }
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update_comment', $comment);
        // Log::alert($comment);
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

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Комментарий успешно удалён.');
    }

    public function accept(Comment $comment)
    {
        // Gate::authorize('update_comment', $comment);
        $comment->accept = true;
        $comment->save();
        return redirect()->route('comment.index');
    }
    public function reject(Comment $comment)
    {
        // Gate::authorize('update_comment', $comment);
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');
    }
}