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
        $collection = Competitor::select('name','price','downloads')->orderBy('downloads', 'desc')->get();
        return $collection;
    }
    public function getModelsHistory() {
        $collection_history = CompetitorHistory::select('name','downloads')->selectRaw("DATE(created_at) as created_date")->orderBy('name')->get();
        foreach ($collection_history as $key => $value) {
            echo $key ,'--', $value, PHP_EOL;
         }
        return $collection_history;
    }
}
