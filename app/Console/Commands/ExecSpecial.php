<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AppointmentRegistration;
use App\Models\AppointmentList;

class ExecSpecial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'e:s';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'execute:special';

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
     * @return mixed
     */
    public function handle()
    {

        echo 'start'."\n";
        $ary = [];

        for($i=1;$i<=500;$i++){
            array_push($ary, $i);
        }

        AppointmentRegistration::whereIn('id', $ary)
            ->update(['appointment_result' => null]);

        echo 'end';
    }
}
