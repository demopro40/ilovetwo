<?php
namespace App\Services;

//phpoffice/phpspreadsheet 範例
//https://kirin.idv.tw/phpspreadsheet-101-basic-usage/
use Illuminate\Support\Facades\Storage;

class ExcelService
{

    // private function readExcel()
    // {
    //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //     $spreadsheet = $reader->load(storage_path('app/uploads/data.xlsx'));
    //     $sheet = $spreadsheet->getSheet(0);
    //     $cellCollection = $sheet->getCellCollection();
    //     $column = $cellCollection->getHighestRowAndColumn();

    //     $data = [];

    //     讀取A1欄位的資料
    //     echo $sheet->getCell('A1')->getValue();

    //     讀取全部資料
    //     for($i = 1; $i <= $column['row']; $i++){//行
    //         for($j = 'A'; $j <= $column['column']; $j++){//列
    //             $key = $j.$i;
    //             $value = $sheet->getCell($key)->getValue();
    //             $data[$key] = $value;
    //         }
    //     }
       
    //     讀取C2,C3,C4行的資料
    //     for($j = 'C'; $j <= 'H'; $j++){
    //         $key = $j.'2';
    //         $value = $sheet->getCell($key)->getValue();
    //         $data[$key] = $value;
    //     }

    //     for($j = 'C'; $j <= 'H'; $j++){
    //         $key = $j.'3';
    //         $value = $sheet->getCell($key)->getValue();
    //         $data[$key] = $value;
    //     }

    //     for($j = 'C'; $j <= 'H'; $j++){
    //         $key = $j.'4';
    //         $value = $sheet->getCell($key)->getValue();
    //         $data[$key] = $value;
    //     }
        
    //     dump($data);
    // }

    // private function createExcel()
    // {
    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('B1','testing');

    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    //     $writer->save(storage_path('app/uploads/test1.xlsx'));
    // }

    // private function createExcelForUser()
    // {
    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('B1','testing');

    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    //     $writer->save('test1');

    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="test1.xlsx"');
    //     header('Cache-Control: max-age=0');
    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    //     $writer->save('php://output');
    // }

    public function readExcelData($file, $sheet, $ary)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load(storage_path('app/uploads/'.$file.'.xlsx'));
        $sheet = $spreadsheet->getSheet($sheet);
        $cellCollection = $sheet->getCellCollection();
        $column = $cellCollection->getHighestRowAndColumn();

        $check_data_file = Storage::disk('uploads')->has($file.'.xlsx');
        
        $data = [];
        $data2 = [];

        if($check_data_file){
            for($i = 2; $i <= $column['row']; $i++){
                
                if($sheet->getCell('A'.$i)->getValue() == null) continue;

                foreach($ary as $key => $value){
                    $data2[$value] = $sheet->getCell($key.$i)->getValue();
                }

                array_push($data, $data2);
            }
        }else{
            echo 'data file does not exist';
            exit;
        }

        return $data;
    }

}