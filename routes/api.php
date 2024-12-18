<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIControllers\ArticleController;
use App\Http\Controllers\APIControllers\AuthController;
use App\Http\Controllers\APIControllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
route::get('/auth/signup', [AuthController::class,'signup']);
route::post('/aut/registr', [AuthController::class,'registr']);
route::get('/auth/login', [AuthController::class,'login'])->name('login');
route::post('/auth/signin', [AuthController::class,'authenticate']);
route::get('auth/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');



//Article
route::resource('/article', ArticleController::class)->middleware('auth:sanctum');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show')->middleware('click');

// route::get('/', [MainController::class, 'index' ]);
// route::get('/galery/{img}', function($img){
//     return view('main.galery', ['img' => $img, 'name' => 'name']);
// });

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
