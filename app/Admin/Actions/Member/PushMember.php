<?php

namespace App\Admin\Actions\Member;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AppointmentList;


class PushMember extends BatchAction
{
    public $name = '確認推播';
    protected $selector = '.push-member';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $username = $model->username;
            $appointment_username = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
            $appointment_user_new = AppointmentList::where('username', $username)->pluck('appointment_user_new')->first();
            if($appointment_username != null){
                $appointment_username = $appointment_username.'、';
            }
            $update = [
                'appointment_username' => $appointment_username.$appointment_user_new,
                'appointment_user_new' => '',
                'appointment_user_latest' => $appointment_user_new
            ];
            AppointmentList::where('username', $username)->update($update);
        }

        return $this->response()->success('Success')->refresh();
    }

}