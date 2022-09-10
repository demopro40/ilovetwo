<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentList;
use App\Models\MemberData;
use App\Models\AppointmentRegistration;
use App\Services\PairTimeService;

class AppointmentApiController extends Controller
{
    public function __construct(PairTimeService $pairTimeService)
    {
        $this->pairTimeService = $pairTimeService;
    }

    public function addMember(Request $request)
    {
        $password = $request->input('password');
        if($password != '2BGf9RZXDrgJ'){
            return false;
        }
        
        $str = '';
        $appointmentList = AppointmentList::get()->toArray();
        foreach ($appointmentList as $value) {

            //紀錄L 不用推播
            $l_user = MemberData::where('username', $value['username'])->where('pause_push','L')->pluck('username')->first();
            if($l_user == $value['username']){
                continue;
            }
            
            $username = $value['username'];
            $appointment_username = $value['appointment_username'];
            $appointment_user_new = $value['appointment_user_new'];
            $appointment_user_excluded = $value['appointment_user_excluded'];
            $gender = MemberData::where('username', $username)->pluck('gender')->first();
            $appointment_username_ary = explode('、', $appointment_username);
            $appointment_user_new_ary = explode('、', $appointment_user_new);
            $appointment_user_excluded_ary = explode('、', $appointment_user_excluded);
            $ary = array_merge($appointment_username_ary, $appointment_user_new_ary, $appointment_user_excluded_ary);
            $data = MemberData::whereNotIn('username',$ary)
                        ->whereNotIn('gender', [$gender])
                        ->pluck('username')
                        ->toArray();
            if(count($data) > 1){
                $rand_keys = array_rand ($data, 2); 
                $str = $data[$rand_keys[0]].'、'.$data[$rand_keys[1]];
            }
            if(count($data) == 1){
                $str = $data[0];
            } 
            if(count($data) == 0){
                $str = null;
            } 
            AppointmentList::where('username', $username)->update(['appointment_user_new' => $str]);
        }

        return response()->json(['status' => 'success']);
    }

    public function pushMember(Request $request)
    {
        $password = $request->input('password');
        if($password != '2BGf9RZXDrgJ'){
            return false;
        }

        $data = AppointmentList::get()->toArray();
        foreach ($data as $value) {
            $username = $value['username'];
            $appointment_username = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
            $appointment_user_new = AppointmentList::where('username', $username)->pluck('appointment_user_new')->first();
            if($appointment_user_new != null){
                if($appointment_username != null){
                    $appointment_username = $appointment_username.'、';
                }
            }
            $update = [
                'appointment_username' => $appointment_username.$appointment_user_new,
                'appointment_user_new' => '',
                'appointment_user_latest' => $appointment_user_new
            ];
            AppointmentList::where('username', $username)->update($update);
        }

        return response()->json(['status' => 'success']);
    }

    public function goldPushMember(Request $request)
    {
        $password = $request->input('password');
        if($password != '2BGf9RZXDrgJ'){
            return false;
        }

        $all_g_user_ary = MemberData::where('gender','m')->where('plan','G')->get(['username'])->toArray();
        $all_f_user_ary = MemberData::where('gender','f')->get(['username'])->toArray();

        $g_user_ary = [];
        $f_user_ary = [];

        foreach($all_g_user_ary as $value){
            array_push($g_user_ary, $value['username']);
        }
        foreach($all_f_user_ary as $value){
            array_push($f_user_ary, $value['username']);
        }

        $f_user_str = implode('、', $f_user_ary);

        foreach($g_user_ary as $value){
            AppointmentList::where('username',$value)->update(['appointment_username' => $f_user_str, 'appointment_user_new'=>null]);
        }

        return response()->json(['status' => 'success']);
    }

    public function pairTime(Request $request)
    {
        $password = $request->input('password');
        if($password != '2BGf9RZXDrgJ'){
            return false;
        }

        $username_ary = AppointmentRegistration::pluck('username')->toArray();
        $username_ary = array_unique($username_ary);
        foreach($username_ary as $value){
            $this->pairTimeService->set($value);
            \Log::info($value.'排約資料已設定');
        }

        return response()->json(['status' => 'success']);
    }
}
