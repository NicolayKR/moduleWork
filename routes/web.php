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


Route::get('/test', function(){
    $array_data = [];
    $collection_history = CompetitorHistory::select('name','id_modules','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('id')->get();
    foreach ($collection_history as $key => $value) {
            $array_data[$value['id_modules']]['name'] = $value['name'];
            $array_data[$value['id_modules']]['downloads'][] = (int)$value['downloads'];
            $array_data[$value['id_modules']]['dates'][] = $value['created_date'];    
        }
    $dataSet =[];
    $dates = [];
    function rand_color() {
        return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }
    foreach ($array_data as $value){
        $dates = array_merge($dates,$value["dates"]);
        $dates = array_unique($dates);
        $currentData = new stdClass();
        //Название Линии
        $currentData->label = $value["name"];
        //Количество скачиваний
        $currentData->data = $value["downloads"];
        //Рандомный цвет
        $currentData->borderColor = rand_color();
        //
        $currentData->backgroundColor = 'transparent'; 
        $currentData->borderWidth = 2;
        array_push($dataSet, $currentData);
    }
    return $dataSet;
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
