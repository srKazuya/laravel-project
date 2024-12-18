<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Events\NewArticleEvent;



class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $articles = Cache::remember('articles' . $page, 3000, function () {
            return Article::latest()->paginate(6);
        });
        return response()->json($articles);
        return response($articles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key' => 'articles*[0-9]'])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }
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
        if ($article->save()) {
            NewArticleEvent::dispatch($article);
            return redirect('/article');
            if ($aricle->save()) return response(1, 200);
            else return response(0, 507);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        if (isset($_GET['notify'])) auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        // $user = User::findOrFail($article->user_id);
        $result = Cache::rememberForever('comment_article' . $article->id, function () use ($article) {
            $comments =  Comment::where('article_id', $article->id)
                ->where('accept', true)
                ->get();
            $user = User::findorFail($article->user_id);
            return [
                'comments' => $comments,
                'user' => $user
            ];
        });

        return response()->json([
            'article' => $article,
            'user' => $result['user'],
            'commentsx' => $result['comments'],
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return response()->json($article);     // compact('article')
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key' => 'articles*[0-9]'])->get();
        foreach ($keys as $param) {
            Cache::forget($param->key);
        }
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
            return response(1,200);
            
        } else {
            return response(0,507);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', [self::class]);
        Cache::flush();
        if ($article->delete()) {
            return response(1,200)->th('success', 'Article deleted successfully.');
        } else {
            return response(0,507)->with('error', 'Failed to delete article.');
        }
    }
}
