<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExcelService;
use App\Models\MemberData;
use App\Models\AppointmentList;
use App\Models\Restaurant;
use App\Models\RestaurantDate;
use App\Models\VideoDate;

class InsertExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:excel {sheet}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert:excel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ExcelService $excel_service)
    {
        parent::__construct();
        $this->excel_service = $excel_service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->insertData($this->argument('sheet'));
    }

    private function insertData($sheet)
    {
        echo 'start';

        if($sheet == 1 || $sheet == 0){
            $ary = [
                'A' => 'username',
                'B' => 'identity',
                'C' => 'phone',
                'D' => 'email',
                'E' => 'gender',
                'F' => 'consultant',
                'G' => 'data_url',
                'H' => 'data_url_simple',
                'I' => 'plan',
                'J' => 'live_place',
                'K' => 'birth_place',
                'L' => 'in_love',
                'M' => 'describe',
                'N' => 'like_trait',
                'O' => 'frequency'
            ];
            $data_file = $this->excel_service->readExcelData('data', 1, $ary);
            if($data_file !== null){
                MemberData::insert($data_file);
            }
        }

        if($sheet == 2 || $sheet == 0){
            $ary = [
                'A' => 'username',
                'B' => 'appointment_username',
                'C' => 'appointment_user_new',
                'D' => 'appointment_user_latest',
                'E' => 'appointment_user_excluded'
            ];
            $data_file = $this->excel_service->readExcelData('data', 2, $ary);
            if($data_file !== null){
                AppointmentList::insert($data_file);
            }
        }

        if($sheet == 4 || $sheet == 0){
            $ary = [
                'A' => 'place',
                'B' => 'url',
                'C' => 'qualification',
            ];
            $data_file = $this->excel_service->readExcelData('data', 4, $ary);
            if($data_file !== null){
                Restaurant::insert($data_file);
            }
        }

        if($sheet == 5 || $sheet == 0){
            $ary = [
                'A' => 'datetime',
            ];
            $data_file = $this->excel_service->readExcelData('data', 5, $ary);
            if($data_file !== null){
                RestaurantDate::insert($data_file);
            }
        }

        if($sheet == 6 || $sheet == 0){
            $ary = [
                'A' => 'datetime',
            ];
            $data_file = $this->excel_service->readExcelData('data', 6, $ary);
            if($data_file !== null){
                VideoDate::insert($data_file);
            }
        }

        echo 'end';

    }

}
