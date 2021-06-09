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


Route::get('/test', function(){
    // $collection_history = CompetitorHistory::select('id_modules','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('id')->get();
    // $array_data = array();
    // foreach ($collection_history as $key => $value) {
    //         $array_data[$value['id_modules']]['downloads'][] = $value['downloads'];
    //         $array_data[$value['id_modules']]['dates'][] = $value['created_date'];    
    //     }
    // return $array_data;
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
