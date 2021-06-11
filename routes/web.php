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
        function rand_color() {
            return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
        }
        $array_data = [];
        $dates = [];
        $collection = Competitor::select('name','id','price','downloads')->orderBy('downloads', 'desc')->get();
        foreach ($collection as  $value) {
            $array_data[$value['id']]['name'] = $value['name'];
            $array_data[$value['id']]['current_downloads'] = $value['downloads'];
            $array_data[$value['id']]['price'] = $value['price'];
        }
        $collection_history = CompetitorHistory::select('name','id_modules','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('id')->get();
        foreach ($collection_history as  $value) {
                $array_data[$value['id_modules']]['downloads'][] = (int)$value['downloads'];
                $array_data[$value['id_modules']]['dates'][] = $value['created_date']; 
                if (!array_key_exists('borderColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['borderColor'][] = rand_color();
                }
                if (!array_key_exists('backgroundColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['backgroundColor'][] = 'transparent';
                }
                if (!array_key_exists('borderWidth', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['borderWidth'][] = 2;
                }
            }
        return $array_data;
    
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
