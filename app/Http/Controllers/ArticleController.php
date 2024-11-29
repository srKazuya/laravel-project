<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;



class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(6);

        return view('article.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', [self::class]);

        $request->validate([
            'date' => 'required|date',
            'name' => 'required|max:255',
            'desc' => 'required|max:255',
        ]);

        $article = new Article();
        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;


        // Article::create($request->all());
        $article->save();
        return redirect('/article');
        if ($aricle->save()) return redirect('/article');
        else return back()->withInput()->withErrors(['error' => 'Could not save article']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $user = User::findOrFail($article->user_id);
        $comments = Comment::where('article_id', $article->id)->get();

        return view('article.show', [
            'article' => $article,
            'user' => $user,
            'comments' => $comments,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.update', ['article' => $article]);
        // compact('article')
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {

        Gate::authorize('update', $article);


        $request->validate([
            'date' => 'required|date',
            'name' => 'required|max:255',
            'desc' => 'required|max:255',
        ]);

        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;



        if ($article->save()) {

            return redirect('/article')->with('success', 'Article updated successfully.');
        } else {

            return redirect()->back()->with('error', 'Failed to update article.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', [self::class]);

        // Пытаемся удалить статью
        if ($article->delete()) {
            // Если удаление успешно, перенаправляем с сообщением об успехе
            return redirect('/article')->with('success', 'Article deleted successfully.');
        } else {
            // Если ошибка удаления, перенаправляем с ошибкой
            return redirect()->back()->with('error', 'Failed to delete article.');
        }
    }
}
