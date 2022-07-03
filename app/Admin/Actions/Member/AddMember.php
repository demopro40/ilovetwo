<?php

namespace App\Admin\Actions\Member;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\MemberData;
use App\Models\AppointmentList;

class AddMember extends BatchAction
{
    public $name = '新增推播';
    protected $selector = '.add-member';
    public function handle(Collection $collection)
    {
        $str = '';
        foreach ($collection as $model) {
            $username = $model->username;
            $appointment_username = $model->appointment_username;
            $appointment_user_new = $model->appointment_user_new;
            $appointment_user_excluded = $model->appointment_user_excluded;
            $gender = MemberData::where('username', $username)->pluck('gender')->first();
            $appointment_username_ary = explode('、', $appointment_username);
            $appointment_user_ary = explode('、', $appointment_user_new);
            $appointment_user_excluded_ary = explode('、', $appointment_user_excluded);
            $ary = array_merge($appointment_username_ary, $appointment_user_ary, $appointment_user_excluded_ary);
            $data = MemberData::whereNotIn('username',$ary)->where('gender', '!=' ,  $gender)->pluck('username')->toArray();
            if(count($data) > 1){
                $rand_keys = array_rand ($data, 2); 
                $str = $data[$rand_keys[0]].'、'.$data[$rand_keys[1]];
            }
            if(count($data) == 1){
                $str = $data[0];
            } 
            if(count($data) == 0){
                $str = '';
            } 
            AppointmentList::where('username', $username)->update(['appointment_user_new' => $str]);
        }

        return $this->response()->success('Success')->refresh();
    }

}