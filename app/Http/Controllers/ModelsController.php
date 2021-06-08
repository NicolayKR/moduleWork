<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use DiDom\Document;
use DiDom\Query;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function getModels() {
        $collection = Competitor::select('name','price','downloads')->orderBy('downloads', 'desc')->get();
        return $collection;
    }
}
