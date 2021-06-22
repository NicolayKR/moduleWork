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

// Route::get('/', function () {
//     return view('index');
// });
//Route::get('/getModels', 'App\Http\Controllers\ModelsController@getModels');

Route::get('/getModels', 'App\Http\Controllers\ModelsController@getModels');
Route::get('/getGraphData', 'App\Http\Controllers\ModelsController@getGraphData');
Route::get('/getGraphLabel', 'App\Http\Controllers\ModelsController@getGraphLabel');
Route::name('user.')->group(function(){
    //Если пользвателоь авторизован, переместим на страницу с графиками
    Route::view('/','index')->middleware('auth')->name('private');
    Route::get('/login', function(){
        if(Auth::check()){
            return redirect(route(name: 'user.private'));
        }
        return view('login');
    })->name('login');
    Route::post('/login', 'App\Http\Controllers\LoginController@login');
    Route::get('/registration', function(){
        if(Auth::check()){
            return redirect(route(name: 'user.private'));
        }
        return view('registration');
    })->name('registration');
    Route::post('/registration','App\Http\Controllers\RegisterController@save');

    Route::get('/logout', function(){
        Auth::logout();
        return redirect('login');
    })->name('logout');
});

Route::get('/test', function(){
    // $case_par = 3;
    // $start_date = 'YEAR(DATE_SUB(DATE(NOW()), INTERVAL 1 YEAR))';
    // $finish_date ='YEAR(DATE(NOW() + INTERVAL 1 YEAR))';
    // $range ='year(';
    // $collection = Competitor::select('name','id','price','downloads')->orderBy('downloads', 'desc')->get();
    // $collection_history = CompetitorHistory::select('name','id_modules')
    //                                 ->selectRaw("month(created_at) as created_date")
    //                                 ->selectRaw("max(downloads) as downloads")
    //                                 ->whereRaw($range."created_at)"."BETWEEN ".$start_date." and ".$finish_date."")
    //                                 ->groupBy('name','id_modules')
    //                                 ->groupByRaw('month(created_at)')
    //                                 ->orderBy('downloads', 'desc')->get();  
                                   
    // $array_data = [];
    // $dates = [];
    // foreach ($collection_history as  $value) {
    //         $array_data[$value['id_modules']]['dates'][] = $value['created_date'];
    //         if($case_par == 3){
    //             $current_array_downloads = [];
    //             for($index = 0; $index < 12 ; $index++){
    //                 array_push($current_array_downloads,0);
    //             }
    //             $array_data[$value['id_modules']]['downloads'] = $current_array_downloads;
    //             foreach ($collection_history as  $value) {
    //                 for($index = 0; $index < 12 ; $index++){
    //                     if($index == (int)$value['created_date']-1){
    //                         $array_data[$value['id_modules']]['downloads'][$index] = (int)$value['downloads'];
    //                     }
    //                 }
    //             }
    //         }
    //         else{
    //             $array_data[$value['id_modules']]['downloads'][] = (int)$value['downloads'];
    //         }
    //     }
    //     foreach ($collection as  $value) {
    //         $array_data[$value['id']]['price'] = (int)$value['price'];
    //     }
    //     $final_array = [];
    //     $i = 0;
    //     $max_lenght_downloads = 0;
    //     $lenght_downloads = 0;
    //     foreach($array_data as $value){
    //         $lenght_downloads = count($value['downloads']);
    //         if($max_lenght_downloads < $lenght_downloads){
    //             $max_lenght_downloads = $lenght_downloads;
    //         }
    //         if($lenght_downloads < $max_lenght_downloads){
    //             $res = $max_lenght_downloads - $lenght_downloads;
    //             for($j=0; $j<$res; $j++){
    //                 array_push($value['downloads'], 0);
    //             }
    //         }
    //         $value['lenght_downloads'] = $lenght_downloads;
    //         if($case_par!=3){
    //             sort($value['downloads']);
    //             sort($value['dates']);
    //         }
    //         $final_array[$i] = $value;
    //         $i++;
    //     }
    //     return $final_array;   
});
