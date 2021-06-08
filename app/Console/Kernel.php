<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Competitor;
use App\Console\Commands\UpdateDb;
use DiDom\Document;
use DiDom\Query;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\UpdateDb',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function(){
        //     $url = 'https://www.bitrix24.ru/apps/?q=%D0%BD%D0%B5%D0%B4%D0%B2%D0%B8%D0%B6%D0%B8%D0%BC%D0%BE%D1%81%D1%82%D1%8C'; 
        // $referer = 'http://www.google.com';
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_REFERER, $referer);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch); 
        // curl_close($ch);
        // $doc = new Document();
        // $doc->loadHtml($response);
        // $array_a_navigate_item = [];
        // array_push($array_a_navigate_item, $url."&PAGEN_1=1");
        // $navigate = $doc->find('.page-navigation__item');
        // $collection = Competitor::select('name')->get()->values()->all();
        // date_default_timezone_set("Europe/Moscow");
        // for($i = 1; $i < count($navigate); $i++){
        //     array_push($array_a_navigate_item, 'https://www.bitrix24.ru'.$doc->find('.page-navigation__item')[$i]->attr('href'));
        // }
        // for($i = 0; $i < count($array_a_navigate_item); $i++) {
        //     $array_a_module_item = [];
        //     $url = $array_a_navigate_item[$i];
        //     $referer = 'http://www.google.com';
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_HEADER, false);
        //     curl_setopt($ch, CURLOPT_REFERER, $referer);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $response = curl_exec($ch); 
        //     curl_close($ch);
        //     $doc = new Document();
        //     $doc->loadHtml($response); 
        //     $c=0;
        //     foreach($doc->find('.apps-catalog-list__body-item') as $value) {
        //         array_push($array_a_module_item, 'https://www.bitrix24.ru'.$value->find('a')[0]->attr('href'));
        //     }
        //     foreach($array_a_module_item as $value) {
        //         $url_a = $value; 
        //         $ch_a = curl_init();
        //         curl_setopt($ch_a, CURLOPT_URL, $url_a);
        //         curl_setopt($ch_a, CURLOPT_HEADER, false);
        //         curl_setopt($ch_a, CURLOPT_REFERER, $referer);
        //         curl_setopt($ch_a, CURLOPT_RETURNTRANSFER, true);
        //         $response = curl_exec($ch_a); 
        //         curl_close($ch_a);
        //         $doc_page = new Document();
        //         $doc_page->loadHtml($response);          
        //         //Секция вывода значений
        //         $flag_price = false;
        //         $current_item_price = 0;
        //         $current_item_name = $doc_page->find('.apps-catalog-detail__name')[0]->text();//Имя
        //         foreach($doc_page->find('.apps-catalog-detail__sidebar-text') as $value){
        //             if(strcmp($value->text(),"содержит встроенные покупки") == 0 ){
        //                 $flag_price = true;
        //                 $current_item_price = 1;
        //             }
        //         }
        //         if($flag_price){
        //             $current_item_download = $doc_page->find('.apps-catalog-detail__sidebar-text')[2]->text();
        //         }else{
        //             $current_item_download = $doc_page->find('.apps-catalog-detail__sidebar-text')[1]->text();
        //         }
        //         $result = Competitor::select(Competitor::raw('COUNT(*)'))->where('name', $current_item_name)->count(); 
        //             if($result == 1) {
        //                 Competitor::where('name', '=', $current_item_name)->update(array(
        //                     'price'   => $current_item_price,
        //                     'downloads' =>  mb_strimwidth($current_item_download, 11, strlen($current_item_download))
        //                   ));
        //             } else{
        //                 $newModules= Competitor::create(array(
        //                     'name'  => $current_item_name,
        //                     'price' => $current_item_price,
        //                     'downloads'=> mb_strimwidth($current_item_download, 11, strlen($current_item_download))
        //                 ));
        //                 $newModules->save();
        //             }               
        //     }
        // }  
        // })->everyMinute();
        $schedule->command('update')->everyMinute(); 
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
