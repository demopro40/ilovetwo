<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ChartController extends Controller
{
    
    public function index(Content $content)
    {
        $content->title('約會調查圖表');
        $content->description('Date Survey Chart');
        $data = [];

        $this->read_excel();

        $content->view('admin.chart', ['data' => $data]);
        return $content;    
    }

    private function read_excel()
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(storage_path('app/uploads/dating_survey_m.xlsx'));
        $sheet = $spreadsheet->getSheet(0);
        $cellCollection = $sheet->getCellCollection();
        $column = $cellCollection->getHighestRowAndColumn();
        echo $sheet->getCell('A1')->getValue();
    }

    private function create_excel()
    {
        
    }

}
