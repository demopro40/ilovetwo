<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

class OtherController extends Controller
{
    public function __construct()
    {

    }

    public function index(Content $content)
    {
        $content->title('其他');
        $content->description('Other functions');

        // $content->breadcrumb(
        //     ['text' => '首页', 'url' => '/admin'],
        //     ['text' => '用户管理', 'url' => '/admin/users'],
        //     ['text' => '编辑用户']
        // );

        $html = 'Download csv file'."<br>"; 
        $html .= 'https://ilove2twods.com/admin/Download/1'."<br>".'下載member_data表'."<br>"."<br>";
        $html .= 'https://ilove2twods.com/admin/Download/2'."<br>".'下載appointment_lists表'."<br>"."<br>";
        $html .= 'https://ilove2twods.com/admin/Download/3'."<br>".'下載appointment_registrations表'."<br>"."<br>";
        $html .= 'https://ilove2twods.com/admin/Download/4'."<br>".'下載restaurants表'."<br>"."<br>";
        $html .= 'https://ilove2twods.com/admin/Download/5'."<br>".'下載restaurant_dates表'."<br>"."<br>";
        $html .= 'https://ilove2twods.com/admin/Download/6'."<br>".'下載video_dates表'."<br>"."<br>";
        $content->body($html);

        return $content;    
    }

    public function download($dbname)
    {
        $headers = [
            'Content-Encoding: UTF-8',
            'Content-Type' => 'text/csv',
        ];

        if($dbname == 1){
            $dbname = 'member_data';
        }
        if($dbname == 2){
            $dbname = 'appointment_lists';
        }
        if($dbname == 3){
            $dbname = 'appointment_registrations';
        }
        if($dbname == 4){
            $dbname = 'restaurants';
        }
        if($dbname == 5){
            $dbname = 'restaurant_dates';
        }
        if($dbname == 6){
            $dbname = 'video_dates';
        }

        return response()->streamDownload(function () use ($dbname) {
            echo "\xEF\xBB\xBF";
            //echo "欄位1,欄位2,欄位3\n";
            //echo "11,22,33\n";
            //echo "11,22,33\n";
            $this->getData($dbname);
        }, $dbname.'.csv', $headers);
    }


    protected function getData($dbname)
    {
        \DB::table($dbname)
        // ->select('id', 'name', 'email')
        ->orderBy('id', 'desc')
        ->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                echo implode(',', (array) $row) . "\n";
            }
        });
    }

}
