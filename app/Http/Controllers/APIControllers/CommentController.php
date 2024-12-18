<?php

namespace App\Http\Controllers\APIControllers;


use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCommentMail;
use App\Jobs\VeryLongJob;

class CommentController extends Controller
{


    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $comments = Cache::remember('comments'.$page, 3000, function(){
            return Comment::latest()->paginate(10);
        });
        return view('comments.index', ['comments' => $comments]);
    }


    public function store(Request $request)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=> 'comments*[0-9]'])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }

        
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
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=> 'comments*[0-9]'])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=> 'comment_article'.$comment->article_id])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }
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
        Cache::flush();
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Комментарий успешно удалён.');
    }

    public function accept(Comment $comment)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=> 'comments*[0-9]'])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=> 'comment_article'.$comment->article_id])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }
        
        $users = User::where('id', '!=', $comment->user_id)->get();
        $article = Article::findorFail($comment->article_id);
        // Gate::authorize('update_comment', $comment);
        $comment->accept = true;
        if($comment->save()) Notification::send($users, new NewCommentNotify($article,  $comment->name));
        return redirect()->route('comment.index');
    }
    public function reject(Comment $comment)
    {
        Cache::flush();
        // Gate::authorize('update_comment', $comment);
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');
    }
}