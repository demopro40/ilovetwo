<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Services\ExcelService;

class UploadController extends Controller
{

    public function __construct(ExcelService $excel_service)
    {
        $this->excel_service = $excel_service;
    }
    
    public function index(Content $content)
    {
        $content->title('上傳檔案');
        $content->description('upload file');
        $data = [];

        $content->view('admin.upload', ['data' => $data]);

        return $content;    
    }

    public function upload_post(Request $request)
    {
        if($request->isMethod('POST')){

            $file = $request->file('file');

            //檔案是否上傳成功
            if($file->isValid()){

                //獲取原檔名
                $originalName = $file->getClientOriginalName();

                $this->check($originalName);

                //獲取檔案拓展名
                $ext= $file->getClientOriginalExtension();

                //獲取檔案臨時絕對路徑
                $realPath = $file->getRealPath();

                //自定義檔案儲存的名稱
                $fileName = $originalName;

                $bool =  Storage::disk('uploads')->put( $fileName, file_get_contents($realPath));

                if($bool){
                    return redirect('/admin/Upload');
                }else{
                    \Log::error('上傳檔案失敗');
                }
            }
        }

    }

    private function check($originalName)
    {
        if($originalName == 'data.xlsx'){

            return true;

        }elseif($originalName == 'data222222222222222222222222222.xlsx'){

            return true;

        }else{

            echo '上傳檔案名稱錯誤';
            exit;
        }
    }
}
