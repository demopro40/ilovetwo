<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberData;
use App\Models\Restaurant;
use App\Models\RestaurantDate;
use App\Models\VideoDate;
use App\Models\AppointmentList;
use App\Models\MemberLoginLog;
use App\Models\AppointmentRegistration;
use App\Services\PairTimeService;
use Session;
use Validator;

class DateController extends Controller
{
    public function __construct(PairTimeService $pairTimeService)
    {
        $this->pairTimeService = $pairTimeService;
    }

    public function login()
    {
        if(Session::has('username')){
            return redirect('/date/data');
        }
        return view('date.login');
    }

    public function login_post(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');
        $ip_address = $request->ip();

        $rules = [
            'account' => 'required', 
            'password' => 'required',
        ];
        $messages = [
            'account.required' => '帳號為必填',
            'password.required' => '密碼為必填',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/date/login')->withErrors($validator)->withInput();
        }

        $username = MemberData::where([
            'identity' => $account,
            'phone' => $password
        ])->pluck('username')->first();

        if($username != null){
            $MemberLoginLog = new MemberLoginLog();
            $MemberLoginLog->account = $account;
            $MemberLoginLog->password = $password;
            $MemberLoginLog->ip_address = $ip_address;
            $MemberLoginLog->status = 'success';
            $MemberLoginLog->save();
            Session::put('username', $username);
            return redirect('/date/data');
        }else{
            $MemberLoginLog = new MemberLoginLog();
            $MemberLoginLog->account = $account;
            $MemberLoginLog->password = $password;
            $MemberLoginLog->ip_address = $ip_address;
            $MemberLoginLog->status = 'fail';
            $MemberLoginLog->save();
            Session::flash('error_msg', '帳號或密碼登入錯誤');
            return redirect('/date/login');
        }
    }

    public function data()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }

        $username = Session::get('username'); 
        $data = [];

        //會員名稱
        $data['username'] = $username;

        //推播對象
        $push_member = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
        $push_member = explode('、', $push_member);
        $data['push_data'] = MemberData::whereIn('username', $push_member)->get(['username', 'gender', 'data_url', 'data_url_simple', 'plan'])->toArray();

        // //會員資料連結顯示
        $check = MemberData::where('username', $username)->get(['gender','plan'])->toArray();
        if($check[0]['gender'] == 'm'){
            if($check[0]['plan'] == 'G' || $check[0]['plan'] == 'C' || $check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }
        if($check[0]['gender'] == 'f'){
            if($check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }

        return view('date.data', [ 'data' => $data ]);
    }

    public function invitation()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        
        $username = Session::get('username');
        $data = [];

        //約會餐廳
        $plan = MemberData::where('username', $username)->pluck('plan')->first();
        if($plan != 'G'){
            $data['restaurant'] = Restaurant::where('qualification', 'no')->get(['place', 'url'])->toArray();
        }else{
            $data['restaurant'] = Restaurant::get(['place', 'url'])->toArray();
        }
       
        //顯示餐廳約會時間
        $data['restaurant_date'] = RestaurantDate::get(['datetime'])->toArray();

        //顯示視訊約會時間
        $data['video_date'] = VideoDate::get(['datetime'])->toArray();

        //推播對象
        $push_member = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
        $push_member = explode('、', $push_member);
        $data['push_data'] = MemberData::whereIn('username', $push_member)->get(['username', 'gender', 'data_url', 'data_url_simple', 'plan'])->toArray();

        return view('date.invitation', [ 'data' => $data ]);
    }

    public function invitation_post(Request $request)
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }

        $username = Session::get('username');
        $type = $request->input()['type'];
        if($request->input()['type'] == 'type1'){
            $rules = [
                'chat_option' => 'required',
                'datetime' => 'required',
                'push_user' => 'required'
            ];
            $messages = [
                'chat_option.required' => '請選擇視訊約會流程',
                'datetime.required' => '請選擇視訊聊天時間',
                'push_user.required' => '請選擇排約對象'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('member_data')->withErrors($validator)->withInput();
            }
        }
        if($request->input()['type'] == 'type2'){
            $rules = [
                'date_restaurant' => 'required',
                'datetime2' => 'required',
                'push_user' => 'required'
            ];
            $messages = [
                'date_restaurant.required' => '請選擇約會餐廳',
                'datetime2.required' => '請選擇餐廳約會時間',
                'push_user.required' => '請選擇排約對象'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('member_data')->withErrors($validator)->withInput();
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('member_data')->withErrors($validator)->withInput();
        }

        $push_ary = $request->input()['push_user'];
        foreach($push_ary as $value){
            AppointmentRegistration::where('appointment_user', $value)->where('username', $username)->delete();
            $AppointmentRegistration = new AppointmentRegistration();
            $AppointmentRegistration->username = $username;
            if($type == "type1"){
                $AppointmentRegistration->type = '視訊約會';
                $datetime = implode("、",$request->input()['datetime']);
                switch ($request->input()['chat_option']){
                    case 'v_1':
                        $AppointmentRegistration->chat_option = '自由聊天';
                        break;
                    case 'v_2':
                        $AppointmentRegistration->chat_option = '選擇話題聊天';
                        break;
                    case 'v_3':
                        $AppointmentRegistration->chat_option = '破冰遊戲>聊天';
                        break;
                }
                //$AppointmentRegistration->restaurant = '0';
                $AppointmentRegistration->datetime = $datetime;
            }
            if($type == "type2"){
                $AppointmentRegistration->type = '餐廳約會';
                $datetime = implode("、",$request->input()['datetime2']);
                //$AppointmentRegistration->chat_option = '0';
                $AppointmentRegistration->restaurant = $request->input()['date_restaurant'];
                $AppointmentRegistration->datetime = $datetime;
            }
            $AppointmentRegistration->appointment_user = $value;
            $AppointmentRegistration->save();
        }

        
        return redirect('/date/data');
    }

    public function respond()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }

        $username = Session::get('username');
        $data = [];
        
        $invitation_data = AppointmentRegistration::where('appointment_user', $username)->get()->toArray();
        foreach($invitation_data as $key => $value){
            $data = MemberData::where('username', $value['username'])->get(['data_url', 'data_url_simple'])->toArray();
            $invitation_data[$key]['data_url'] = $data[0]['data_url'];
            $invitation_data[$key]['data_url_simple'] = $data[0]['data_url_simple'];
        }
        $data['invitation_data'] = $invitation_data;

        //會員資料連結顯示
        $check = MemberData::where('username', $username)->get(['gender','plan'])->toArray();
        if($check[0]['gender'] == 'm'){
            if($check[0]['plan'] == 'G' || $check[0]['plan'] == 'C' || $check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }
        if($check[0]['gender'] == 'f'){
            if($check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }

        return view('date.respond', [ 'data' => $data ]);
    }

    public function respond_post(Request $request)
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $username = Session::get('username');
        $respond_name_ary = $request->input()['respond_name'];

        foreach($respond_name_ary as $key => $value){
            if(!isset($request->input()['respond'.$key])){
                continue;
            }
            $appointment_respond = implode("、", $request->input()['respond'.$key]);
            AppointmentRegistration::where('appointment_user', $username)
            ->where('username', $value)
            ->update(['appointment_respond' => $appointment_respond]);
        }
    
        return redirect('/date/data');
    }

    public function show_result()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $username = Session::get('username');
        $data = [];
        $result = AppointmentRegistration::where('username', $username)
                            ->whereNotNull('appointment_respond')
                            ->where('appointment_respond','!=', 'noSel')
                            ->get()
                            ->toArray();
        $result2 = AppointmentRegistration::where('appointment_user', $username)
                            ->whereNotNull('appointment_respond')
                            ->where('appointment_respond','!=', 'noSel')
                            ->get()
                            ->toArray();  
        foreach($result2 as $key => $value){
            $result2[$key]['username'] = $value['appointment_user'];
            $result2[$key]['appointment_user'] = $value['username'];
        }  

        $data['result'] = array_merge($result,$result2);

        return view('date.show_result', [ 'data' => $data ]);
    }

    public function restaurant()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $data = [];
        $data['restaurant'] = Restaurant::get(['place', 'url'])->toArray();

        return view('date.restaurant', [ 'data' => $data ]);
    }

    public function logout()
    {
        Session::forget('username');
        return redirect('/date/login');
    }

    public function pair_time()
    {
        $username_ary = AppointmentRegistration::pluck('username')->toArray();
        $username_ary = array_unique($username_ary);
        foreach($username_ary as $value){
            $this->pairTimeService->set($value);
            \Log::info($value.'排約資料已設定');
        }
        return redirect()->back();
    }

    public function dating_survey_m()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $data = [];
        return view('date.dating_survey_m', [ 'data' => $data ]);
    }

    public function dating_survey_f()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $data = [];
        return view('date.dating_survey_f', [ 'data' => $data ]);
    }
}