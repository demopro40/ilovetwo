<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

//phpoffice/phpspreadsheet 範例
//https://kirin.idv.tw/phpspreadsheet-101-basic-usage/
//use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ChartController extends Controller
{
    
    public function index(Content $content)
    {
        $content->title('約會調查圖表');
        $content->description('Date Survey Chart');
        $data = [];

        //$this->read_excel();
        //$this->create_excel();
        //$this->create_excel_for_user();

        $content->view('admin.chart', ['data' => $data]);
        return $content;    
    }

    private function read_excel()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load(storage_path('app/uploads/dating_survey_m.xlsx'));
        $sheet = $spreadsheet->getSheet(0);
        $cellCollection = $sheet->getCellCollection();
        $column = $cellCollection->getHighestRowAndColumn();
    
        $data = [];
        for($i = 1; $i <= $column['row']; $i++){//行
            for($j = 'A'; $j <= $column['column']; $j++){//列
                $key = $j.$i;
                $value = $sheet->getCell($key)->getValue();
                $data[$key] = $value;
            }
        }
        dump($data);
    }

    private function create_excel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B1','testing');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(storage_path('app/uploads/test1.xlsx'));
    }

    private function create_excel_for_user()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B1','testing');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('test1');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="test1.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }

}
