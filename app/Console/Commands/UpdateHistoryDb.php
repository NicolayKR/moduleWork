<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Competitor;
use App\Models\CompetitorHistory;
use DiDom\Document;
use DiDom\Query; 

class UpdateHistoryDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:HistoryChange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'show when changed count downloads';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set("Europe/Moscow");
        $collection = Competitor::select('id','link')->get();
    $referer = 'http://www.google.com';
    foreach($collection as $value) {
        $id_current_module = $value->id; 
        $url_a = $value->link; 
        $ch_a = curl_init();
        curl_setopt($ch_a, CURLOPT_URL, $url_a);
        curl_setopt($ch_a, CURLOPT_HEADER, false);
        curl_setopt($ch_a, CURLOPT_REFERER, $referer);
        curl_setopt($ch_a, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch_a); 
        curl_close($ch_a);
        $doc_page = new Document();
        $doc_page->loadHtml($response);          
        //Секция вывода значений
        $flag_price = false;
        $current_item_price = 0;
        $current_item_name = $doc_page->find('.apps-catalog-detail__name')[0]->text();
        //$final_name = str_replace("+", "", $current_item_name);
        foreach($doc_page->find('.apps-catalog-detail__sidebar-text') as $value){
            if(strcmp($value->text(),"содержит встроенные покупки") == 0 ){
                $flag_price = true;
                $current_item_price = 1;
            }
        }
        if($flag_price){
            $current_item_download = $doc_page->find('.apps-catalog-detail__sidebar-text')[2]->text();
        }else{
            $current_item_download = $doc_page->find('.apps-catalog-detail__sidebar-text')[1]->text();
        }
        $newModules= CompetitorHistory::create(array(
            'name'  => $current_item_name,
            'id_modules' =>$id_current_module,
            'downloads'=> mb_strimwidth($current_item_download, 11, strlen($current_item_download))
        ));
        $newModules->save();                   
        }
    }         
}
