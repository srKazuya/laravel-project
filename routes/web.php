<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('/auth/signup', [AuthController::class,'signup']);
route::post('/aut/registr', [AuthController::class,'registr']);
route::get('/auth/login', [AuthController::class,'login'])->name('login');
route::post('/auth/signin', [AuthController::class,'authenticate']);
route::get('auth/logout', [AuthController::class,'logout']);



//Article
route::resource('/article', ArticleController::class)->middleware('auth:sanctum');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show')->middleware('click');

route::get('/', [MainController::class, 'index' ]);
route::get('/galery/{img}', function($img){
    return view('main.galery', ['img' => $img, 'name' => 'name']);
});

route::get('/about', function(){
    return view('main.about');
});

route::get('/contact', function(){
    $data =[
        'city' => 'Moscow',
        'street' => 'Semenovskaya',
        'house' => '38',
        'apartment' => '11',

    ];
    return view('main.contact', ['data' => $data]);
});


//comment
Route::controller(CommentController::class)
    ->prefix('/comment')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', 'store'); // Создание комментария
        Route::get('/{id}/edit', 'edit'); // Форма редактирования комментария
        Route::put('/{comment}/update', 'update'); // Обновление комментария
        Route::get('/{id}/delete', 'delete'); 
        Route::get('/index', 'index')->name('comment.index'); 
        Route::get('/{comment}/accept', 'accept'); 
        Route::get('/{comment}/reject', 'reject'); 
        
    });

// Route::post('/article/{article}/comment', [CommentController::class, 'store'])->name('comment.store');

// Route::get('/', function () {
//     return view('welcome');
// });
//Comments
// route::resource('/comments', CommentController::class);