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
        return $array_data;
    }
}
