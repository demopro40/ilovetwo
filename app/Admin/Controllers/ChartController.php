<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use App\Services\ExcelService;

class ChartController extends Controller
{
    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    public function index(Content $content)
    {
        $content->title('約會調查圖表');
        $content->description('Date Survey Chart');
        $data = [];

        $content->view('admin.chart', ['data' => $data]);
        return $content;    
    }

}
