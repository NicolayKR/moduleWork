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
        $dates = [];
        $collection = Competitor::select('name','id','price','downloads')->orderBy('downloads', 'desc')->get();
        foreach ($collection as  $value) {
            $array_data[$value['id']]['name'] = $value['name'];
            $array_data[$value['id']]['id'] = $value['id'];
            $array_data[$value['id']]['current_downloads'] = $value['downloads'];
            $array_data[$value['id']]['price'] = $value['price'];
        }
        $collection_history = CompetitorHistory::select('name','id_modules','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('id')->get();
        foreach ($collection_history as  $value) {
                $array_data[$value['id_modules']]['downloads'][] = (int)$value['downloads'];
                $array_data[$value['id_modules']]['dates'][] = $value['created_date']; 
                if (!array_key_exists('borderColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['borderColor'][] = $this->rand_color();
                }
                if (!array_key_exists('backgroundColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['backgroundColor'][] = 'transparent';
                }
                if (!array_key_exists('borderWidth', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['borderWidth'][] = 2;
                }
            }
        return $array_data;
    }
    function rand_color() {
            return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }
}
