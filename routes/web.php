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

route::resource('/article', ArticleController::class);

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
// Route::post('/article/{article}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::post('/comment', [CommentController::class, 'store']); 
Route::get('/comment/{id}/edit', [CommentController::class, 'edit']); 
Route::put('/comment/{comment}/update', [CommentController::class, 'update']); 
Route::get('/comment/{id}/delete', [CommentController::class, 'delete']); 
// Route::get('/', function () {
//     return view('welcome');
// });
