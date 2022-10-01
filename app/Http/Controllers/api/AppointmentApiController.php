<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentList;
use App\Models\MemberData;
use App\Models\AppointmentRegistration;
use App\Services\PairTimeService;
use Log;

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

            if(!empty($value['appointment_user_new'])){
                continue;
            }
            
            $username = $value['username'];
            $appointment_username = $value['appointment_username'];
            $appointment_user_new = $value['appointment_user_new'];
            $appointment_user_excluded = $value['appointment_user_excluded'];
            $appointment_username_ary = explode('、', $appointment_username);
            $appointment_user_new_ary = explode('、', $appointment_user_new);
            $appointment_user_excluded_ary = explode('、', $appointment_user_excluded);
            $not_select_ary = array_merge($appointment_username_ary, $appointment_user_new_ary, $appointment_user_excluded_ary);

            $factor = MemberData::where('username', $username)
            ->get(['gender','live_place','birth_place','o_age','o_job','o_height','o_weight','o_income'])
            ->toArray();

            if(!isset($factor[0])) continue;

            $o_ary = $this->pairFactor($factor[0], $not_select_ary);

            if(!isset($o_ary[0])) continue;
           
            $o_count_ary = array_count_values($o_ary);

            $result = [];

            $m = @max($o_count_ary);
            $k = array_search($m, $o_count_ary); 
            $result[0] = $k;

            unset($o_count_ary[$k]);

            $m = @max($o_count_ary);
            $k = array_search($m, $o_count_ary); 
            $result[1] = $k;

            $str = implode("、", $result);

            AppointmentList::where('username', $username)->update(['appointment_user_new' => $str]);
        }

        return response()->json(['status' => 'success']);
    }
	
	private function pairFactor($factor, $not_select_ary=[])
	{
        $data = [];
        $gender = $factor['gender'];
        $live_place = $factor['live_place'];
        $birth_place = $factor['birth_place'];
        $o_age = $factor['o_age'];
        $o_job = $factor['o_job'];
        $o_height = $factor['o_height'];
        $o_weight = $factor['o_weight'];
        $o_income = $factor['o_income'];


        if($o_age != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('age', $o_age)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }
        if($o_job != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('job', $o_job)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }
        if($o_height != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('height', $o_height)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }
        if($o_weight != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('weight', $o_weight)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }
        if($o_income != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('income', ">=" ,$o_income)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }

        if($live_place != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('live_place', $live_place)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }

        if($birth_place != null){
            $res = MemberData::whereNotIn('gender', [$gender])
            ->whereNotIn('username', $not_select_ary)
            ->where('birth_place', $birth_place)
            ->pluck('username')
            ->toArray();
            foreach($res as $value){
                array_push($data, $value);
            }
        }

        $res = MemberData::whereNotIn('gender', [$gender])
                    ->whereNotIn('username', $not_select_ary)
                    ->orderBy(\DB::raw('RAND()')) 
                    ->take(2) 
                    ->pluck('username')
                    ->toArray();
        foreach($res as $value){
            array_push($data, $value);
        }

        return $data;
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

    public function inviteInsertPush(Request $request)
    {
        $password = $request->input('password');
        if($password != '2BGf9RZXDrgJ'){
            return false;
        }

        $data = AppointmentRegistration::get(['appointment_user','username'])->toArray();

        foreach($data as $value){
            $data2 = AppointmentList::where('username', $value['appointment_user'])->get(['appointment_username'])->toArray();
            foreach($data2 as $val){
                $data3 = explode("、",$val['appointment_username']);
                if(!in_array($value['username'], $data3)){
                    array_push($data3, $value['username']);
                    $data4 = implode("、",$data3);
                    AppointmentList::where('username',$value['appointment_user'])->update(['appointment_username'=>$data4]);
                }
            }
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
