<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\CompetitorHistory;
use DiDom\Document;
use DiDom\Query;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function getModels() {
        $array_data = [];
        $collection = Competitor::select('name','id','price','downloads')->orderBy('downloads', 'desc')->get();
        foreach ($collection as $key => $value) {
            $array_data[$value['id']]['name'] = $value['name'];
            $array_data[$value['id']]['current_downloads'] = $value['downloads'];
            $array_data[$value['id']]['price'] = $value['price'];
        }
        return $array_data;
    }
    public function getGraphData(){
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
            $currentData = new \stdClass();
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
    }
    public function getGraphLabel(){
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
        }
        return $dates;
    }
}
