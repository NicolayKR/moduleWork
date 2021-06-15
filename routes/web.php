<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelsController;
use App\Models\CompetitorHistory;
use App\Models\Competitor;
use DiDom\Document;
use DiDom\Query;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
//Route::get('/getModels', 'App\Http\Controllers\ModelsController@getModels');

Route::get('/getModels', 'App\Http\Controllers\ModelsController@getModels');
Route::get('/getGraphData', 'App\Http\Controllers\ModelsController@getGraphData');
Route::get('/getGraphLabel', 'App\Http\Controllers\ModelsController@getGraphLabel');

Route::get('/test', function(){
    $str = 'rgba('.rand(0, 255).','.rand(0, 255).','.rand(0, 255).')';
    return $str;
    
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
