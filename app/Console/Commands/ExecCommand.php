<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AppointmentRegistration;

class ExecCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exec:co';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'execute:command';

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
        $ary = [];

        for($i=1;$i<=7;$i++){
            array_push($ary, $i);
            echo 'update '.'appointment result'.$i."\n";
        }

        AppointmentRegistration::whereIn('id', $ary)
            ->update(['appointment_result' => null]);

        
    }
}
