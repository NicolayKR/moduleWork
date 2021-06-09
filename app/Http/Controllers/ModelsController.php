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
        $array_data = array();
        $collection = Competitor::select('name','id','price','downloads')->orderBy('downloads', 'desc')->get();
        foreach ($collection as $key => $value) {
            $array_data[$value['id']]['name'][] = $value['name'];
            $array_data[$value['id']]['current_downloads'][] = $value['downloads'];
            $array_data[$value['id']]['price'][] = $value['price'];
        }
        $collection_history = CompetitorHistory::select('id_modules','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('id')->get();
        foreach ($collection_history as $key => $value) {
                $array_data[$value['id_modules']]['downloads'][] = $value['downloads'];
                $array_data[$value['id_modules']]['dates'][] = $value['created_date'];    
            }
        return json_encode($array_data);
    }
}
