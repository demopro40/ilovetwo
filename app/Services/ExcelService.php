<?php
namespace App\Services;

//phpoffice/phpspreadsheet 範例
//https://kirin.idv.tw/phpspreadsheet-101-basic-usage/

class ExcelService
{
    public function start()
    {
        $this->read_excel();
    }

    private function read_excel()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load(storage_path('app/uploads/pro1.xlsx'));
        $sheet = $spreadsheet->getSheet(0);
        $cellCollection = $sheet->getCellCollection();
        $column = $cellCollection->getHighestRowAndColumn();
    
        $data = [];
        // for($i = 1; $i <= $column['row']; $i++){//行
        //     for($j = 'A'; $j <= $column['column']; $j++){//列
        //         $key = $j.$i;
        //         $value = $sheet->getCell($key)->getValue();
        //         $data[$key] = $value;
        //     }
        // }
       
        for($j = 'C'; $j <= 'H'; $j++){
            $key = $j.'2';
            $value = $sheet->getCell($key)->getValue();
            $data[$key] = $value;
        }

        for($j = 'C'; $j <= 'H'; $j++){
            $key = $j.'3';
            $value = $sheet->getCell($key)->getValue();
            $data[$key] = $value;
        }

        for($j = 'C'; $j <= 'H'; $j++){
            $key = $j.'4';
            $value = $sheet->getCell($key)->getValue();
            $data[$key] = $value;
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