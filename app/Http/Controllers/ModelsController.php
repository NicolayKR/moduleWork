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
        $collection_history = CompetitorHistory::select('name','id_modules','downloads')
                                ->selectRaw("DATE(created_at) as created_date")
                                ->whereRaw("created_at BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 6 DAY) and date(now()+ INTERVAL 1 DAY)")
                                ->orderBy('downloads', 'desc')->get();
        foreach ($collection_history as  $value) {
                $array_data[$value['id_modules']]['downloads'][] = (int)$value['downloads'];
                $array_data[$value['id_modules']]['dates'][] = $value['created_date']; 
                $current_color = $this->rand_color();
                if (!array_key_exists('name', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['name'] = $value['name'];
                }
                if (!array_key_exists('id', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['id'] = $value['id_modules'];
                }
                if (!array_key_exists('current_downloads', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['current_downloads'] = (int)$value['downloads'];
                }
                if (!array_key_exists('borderColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['borderColor'] = $current_color;
                }
                if (!array_key_exists('backgroundColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['backgroundColor'][] = $current_color;
                }
                else{
                    $array_data[$value['id_modules']]['backgroundColor'][] = $array_data[$value['id_modules']]['backgroundColor'][0];
                }
                if (!array_key_exists('borderWidth', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['borderWidth'] = 2;
                }
                if (!array_key_exists('pointBackgroundColor', $array_data[$value['id_modules']])) {
                    $array_data[$value['id_modules']]['pointBackgroundColor'][] = $current_color;
                }
                else{
                    $array_data[$value['id_modules']]['pointBackgroundColor'][] = $array_data[$value['id_modules']]['pointBackgroundColor'][0];
                }
            }
            foreach ($collection as  $value) {
                $array_data[$value['id']]['price'] = $value['price'];
            }
            $final_array = [];
            $i = 0;
            $max_lenght_downloads = 0;
            $lenght_downloads = 0;
            foreach($array_data as $value){
                $lenght_downloads = count($value['downloads']);
                if($max_lenght_downloads < $lenght_downloads){
                    $max_lenght_downloads = $lenght_downloads;
                }
                if($lenght_downloads < $max_lenght_downloads){
                    $res = $max_lenght_downloads - $lenght_downloads;
                    for($j=0; $j<$res; $j++){
                        array_push($value['downloads'], 0);
                    }
                }
                $value['lenght_downloads'] = $lenght_downloads;
                sort($value['downloads']);
                sort($value['dates']);
                $final_array[$i] = $value;
                $i++;
            }
            return $final_array;
    }
    function rand_color() {
            $str = 'rgba('.rand(0, 255).','.rand(0, 255).','.rand(0, 255).')';
            return $str;
            //return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }
}
