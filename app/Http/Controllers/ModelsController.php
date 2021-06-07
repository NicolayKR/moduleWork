<?php

namespace App\Http\Controllers;

use DiDom\Document;
use DiDom\Query;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function getModels(){
        $url = 'https://www.bitrix24.ru/apps/?q=%D0%BD%D0%B5%D0%B4%D0%B2%D0%B8%D0%B6%D0%B8%D0%BC%D0%BE%D1%81%D1%82%D1%8C'; 
        $referer = 'http://www.google.com';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch); 
        curl_close($ch);

        $doc = new Document();
        $doc->loadHtml($response);

        //Первая страница
        $courses = $doc->find('.apps-catalog-list__body-item');
        $array_a = [];
        //echo (string)count($array)."  ";
        $current_item = $doc->find('.apps-catalog-list__body-item')[0]->find('a')[0]->attr('href');
        //print_r($current_item);
        for($i = 0; $i < count($courses); $i++){
            $current_item = $doc->find('.apps-catalog-list__body-item')[$i]->find('a')[0]->attr('href');
            array_push($array_a, $current_item);
        }
        print_r($array_a);
        $navigate = $doc->find('.page-navigation__item');
        // echo  count($courses);
        // echo count($navigate);
        
        // echo $document->find('apps-catalog-list')[0];//->first('ul.menu')->xpath('//li')[0]->text();
      
    }
}
