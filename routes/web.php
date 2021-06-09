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
Route::get('/getModels', 'App\Http\Controllers\ModelsController@getModels');

Route::get('/getModelsHistory', 'App\Http\Controllers\ModelsController@getModelsHistory');

Route::get('/can', function(){
    
});

Route::get('/test', function(){
    $collection_history = CompetitorHistory::select('id_modules','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('id')->get();
    $array_data = array();
    foreach ($collection_history as $key => $value) {

            $array_current_data = new stdClass();
            $array_current_data->downloads = $value['downloads'];
            $array_current_data->dates = $value['created_date'];
            // foreach($array_data as $current_value){
            //     if(strcmp($current_value->name, $array_current_data->name)==0){
            //         array_push($current_value->downloads, $array_current_data->downloads);
            //         array_push($current_value->dates, $array_current_data->dates);
            //     }
            //     else{     
                     $array_data[$array_current_data->id] = $array_current_data;
            //     }
            // }     
        }
        // foreach($array_data as $current_value){
        //     if(strcmp($current_value->name, 'CRM - Недвижимость')==0){
        //         echo "Нужная строка"."<br>";
        //     }
        //     else{
        //         echo "Ne ta"."<br>";
        //     }
        // }
        return $array_data;
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
