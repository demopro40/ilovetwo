<?php

namespace App\Admin\Actions\Member;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AppointmentList;

class BackMember extends BatchAction
{
    public $name = '推播退回';
    protected $selector = '.back-member';
    public function handle(Collection $collection)
    {
        foreach ($collection as $model){
            $username = $model->username;
            $appointment_user_latest = AppointmentList::where('username', $username)->pluck('appointment_user_latest')->first();
            $appointment_user_latest_ary = explode("、", $appointment_user_latest);
            $appointment_username = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
            $appointment_username_ary = explode("、", $appointment_username);

            $result = array_diff($appointment_username_ary, $appointment_user_latest_ary);
            $result = implode("、", $result);

            AppointmentList::where('username', $username)->update([
                'appointment_username' => $result,
                'appointment_user_latest' => null
            ]);
        }

        return $this->response()->success('Success')->refresh();
    }

}