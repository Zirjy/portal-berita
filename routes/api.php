<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Postcontroller;
use App\Http\Controllers\Autenticationcontroller;
use Laravel\Sanctum\Sanctum;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

route::middleware(['auth:sanctum'])->group(function(){
    route::get('/post', [PostController::class ,'index']);
    route::get('/post/{id}', [PostController::class ,'show']);
    route::post('/post',[PostController::class , 'store']);
    route::get('/logout',[Autenticationcontroller::class, 'logout']);
    route::patch('/post/{id}',[Postcontroller::class, 'update'])->middleware(['post.owner']);
    route::get('/me',[Autenticationcontroller::class, 'me']);
});
route::post('/login',[Autenticationcontroller::class, 'login']);



?>