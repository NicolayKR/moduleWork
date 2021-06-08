<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use DiDom\Document;
use DiDom\Query;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function getModels() {
        $collection = Competitor::select('name as Название модуля','price as Платно','downloads as Скачиваний')->orderBy('downloads', 'desc')->get();
        return $collection;
    }
}
