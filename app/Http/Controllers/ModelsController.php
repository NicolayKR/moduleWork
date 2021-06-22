<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Competitor;
use App\Models\CompetitorHistory;
use DiDom\Document;
use DiDom\Query;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function getModels(Request $request) {
        $date = $request->query('date'); 
        switch ($date) {
            case 1:
                $start_date = 'DATE_SUB(DATE(NOW()), INTERVAL 8 DAY)';
                $finish_date = 'DATE(now()+ INTERVAL 1 DAY)';
                $range ='(';
                $case_par = 1;
                return $this->getData($start_date, $finish_date, $range, $case_par);
            case 2:
                $start_date = 'MONTH(DATE_SUB(DATE(NOW()), INTERVAL 1 MONTH))';
                $finish_date = 'MONTH(DATE(NOW()+ INTERVAL 1 MONTH))';
                $range ='month(';
                $case_par = 2;
                return $this->getData($start_date, $finish_date, $range, $case_par);
            case 3:
                $start_date = 'YEAR(DATE_SUB(DATE(NOW()), INTERVAL 1 YEAR))';
                $finish_date ='YEAR(DATE(NOW() + INTERVAL 1 YEAR))';
                $range ='year(';
                $case_par = 3;
                return $this->getData($start_date, $finish_date, $range, $case_par);
            case 4:
                $start_date = '';
                $finish_date ='';
                $range ='';
                $case_par = 4;
                return $this->getData($start_date, $finish_date, $range, $case_par);  
        } 
    }
    function getData($start_date, $finish_date, $range, $case_par){
        $array_data = [];
        $dates = [];
        $collection = Competitor::select('name','id','price','downloads')->orderBy('downloads', 'desc')->get();
        if($case_par == 4){
            $collection_history = CompetitorHistory::select('name','id_modules','downloads')
                                    ->selectRaw("DATE(created_at) as created_date")
                                    ->orderBy('downloads', 'desc')->get();
            }
       if($case_par == 3) {
            $collection_history = CompetitorHistory::select('name','id_modules')
                                    ->selectRaw("month(created_at) as created_date")
                                    ->selectRaw("max(downloads) as downloads")
                                    ->whereRaw($range."created_at)"."BETWEEN ".$start_date." and ".$finish_date."")
                                    ->groupBy('name','id_modules')
                                    ->groupByRaw('month(created_at)')
                                    ->orderBy('downloads', 'desc')->get();                
        }
        else{
            $collection_history = CompetitorHistory::select('name','id_modules','downloads')
                                    ->selectRaw("DATE(created_at) as created_date")
                                    ->whereRaw($range."created_at)"."BETWEEN ".$start_date." and ".$finish_date."")
                                    ->orderBy('downloads', 'desc')->get();
            }
        foreach ($collection_history as  $value) {
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
                if($case_par == 3){
                    $current_array_downloads = [];
                    for($index = 0; $index < 12 ; $index++){
                        array_push($current_array_downloads,0);
                    }
                    foreach ($collection_history as  $value) {
                        $array_data[$value['id_modules']]['downloads'] = $current_array_downloads;
                    }
                    foreach ($collection_history as  $value) {
                        for($index = 0; $index < 12 ; $index++){
                            if($index == (int)$value['created_date']-1){
                                $array_data[$value['id_modules']]['downloads'][$index] = (int)$value['downloads'];
                            }
                        }
                    }
                }
                else{
                    $array_data[$value['id_modules']]['downloads'][] = (int)$value['downloads'];
                }
            }
            foreach ($collection as  $value) {
                $array_data[$value['id']]['price'] = (int)$value['price'];
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
                if($case_par!=3){
                    sort($value['downloads']);
                    sort($value['dates']);
                }
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
