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
use App\Models\DateMsg;
use App\Services\PairTimeService;
use App\Services\ExcelService;
use Session;
use Validator;

class DateController extends Controller
{
    public function __construct(PairTimeService $pairTimeService, ExcelService $excelService)
    {
        $this->pairTimeService = $pairTimeService;
        $this->excelService = $excelService;
    }

    public function login(Request $request)
    {
        $data = [];
        //http://127.0.0.1:8000/date/login?admin_user=0cnn8jltnecn01v2d8xieaxpj03ttibtbtb2wb5d
        //https://ilove2twods.com/date/login?admin_user=0cnn8jltnecn01v2d8xieaxpj03ttibtbtb2wb5d
        $admin_user = $request->input('admin_user'); 
        if($admin_user !== '0cnn8jltnecn01v2d8xieaxpj03ttibtbtb2wb5d'){
            $data['test'] = env('TEST') ?? false;
        }else{
            Session::put('username', 'Luke');
            $data['test'] = false;
        }

        if(Session::has('username')){
            return redirect('/date/data');
        }

        return view('date.login', [ 'data' => $data ]);
    }

    public function login_post(Request $request)
    {

        $data = [];
        // Google reCAPTCHA 網站密鑰
        $data['secret'] = env('RECAPTCHA_S');
        $data['response'] = $request->input('g-recaptcha-response');
        $ch = curl_init();
        // 使用CURL驗證
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        // 解密
        $result = json_decode($result, true);

        // 檢查是否通過驗證
        if ( !isset($result['success']) || !$result['success']) {
            // 驗證失敗
            Session::flash('error_msg', '驗證失敗');
            return redirect('/date/login');
        } else {
            // 驗證成功
        }

        
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

        if(empty($username)){
            $MemberLoginLog = new MemberLoginLog();
            $MemberLoginLog->account = $account;
            $MemberLoginLog->password = $password;
            $MemberLoginLog->ip_address = $ip_address;
            $MemberLoginLog->status = 'fail';
            $MemberLoginLog->save();
            Session::flash('error_msg', '帳號或密碼登入錯誤');
            return redirect('/date/login');
        }

        $MemberLoginLog = new MemberLoginLog();
        $MemberLoginLog->account = $account;
        $MemberLoginLog->password = $password;
        $MemberLoginLog->ip_address = $ip_address;
        $MemberLoginLog->status = 'success';
        $MemberLoginLog->save();
        Session::put('username', $username);
        return redirect('/date/data');
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
        $result_ary = [];
        $push_member = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
        $push_member = explode('、', $push_member);

        foreach($push_member as  $key => $value){
            $res = MemberData::where('username', $value)
                                ->get(['username', 'gender', 'data_url', 'data_url_simple', 'plan'])
                                ->toArray();
            if(!empty($res)){
                $result_ary[$key] = $res[0];        
            }                                
        }
                      
        $data['push_data'] = array_reverse($result_ary);

        //會員資料連結顯示
        $check = MemberData::where('username', $username)->get(['gender','plan'])->toArray();
        if(!empty($check)){
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
        }
        

        return view('date.data', [ 'data' => $data ]);
    }

    public function invitation()
    {
        if($this->checkDate(1) == false){
            return redirect('/date/data');
        }
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        
        $username = Session::get('username');
        $data = [];
        $data['username'] = $username;
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
        $result_ary = [];
        $push_member = AppointmentList::where('username', $username)->pluck('appointment_username')->first();
        $push_member = explode('、', $push_member);

        foreach($push_member as  $key => $value){
            $res = MemberData::where('username', $value)
                                ->get(['username'])
                                ->toArray();
            if(!empty($res)){
                $result_ary[$key] = $res[0];        
            }                                
        }
                      
        $data['push_data'] = array_reverse($result_ary);

        $registration_username = AppointmentRegistration::where('username', $username)
        ->whereNull('appointment_respond')
        ->whereNull('appointment_result')
        ->pluck('appointment_user')
        ->toArray();
        $data['registration_username'] = $registration_username ?? '';

        return view('date.invitation', [ 'data' => $data ]);
    }

    public function invitation_post(Request $request)
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }

        $username = Session::get('username');
        $type = $request->input()['type'];
        if($type == 'type1'){
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
        if($type == 'type2'){
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

        //主約最多只能約8人
        $invitation_limit = 8;
        $registration_username = AppointmentRegistration::where('username', $username)
        ->whereNull('appointment_respond')
        ->whereNull('appointment_result')
        ->pluck('appointment_user')
        ->toArray();
        if( (count($registration_username)+count($push_ary)) > $invitation_limit){
            return redirect()->back()->withErrors('為促成高約會跟高脫單率，所以每週主約對象限制'.$invitation_limit.'名以內');
        }

        //主約次數用完不可以再約
        $prohibition = MemberData::where('username', $username)->pluck('prohibition')->first();
        if($prohibition == 'N'){
            return redirect()->back()->withErrors('主約次數已用完');
        }

        foreach($push_ary as $value){

            //邀約對方會把自己名子加入對方推播名單
            // $a_user_data = AppointmentList::where('username',$value)->get(['appointment_username'])->toArray();
            // $a_user_data = $a_user_data[0]['appointment_username'] ?? '';
            // $a_user_ary = explode('、', $a_user_data);
            // if(!in_array($username, $a_user_ary)){
            //     array_push($a_user_ary, $username);
            //     $a_user_str =  implode('、', $a_user_ary);
            //     AppointmentList::where('username',$value)->update(['appointment_username' => $a_user_str]);
            // }

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
        if($this->checkDate(2) == false){
            return redirect('/date/data');
        }
        if(!Session::has('username')){
            return redirect('/date/login');
        }

        $username = Session::get('username');
        $data = [];
        $invitation_data = AppointmentRegistration::where('appointment_user', $username)
                                ->whereNull('appointment_result')
                                ->get()
                                ->toArray();
        foreach($invitation_data as $key => $value){ 
            $data = MemberData::where('username', $value['username'])->get(['data_url', 'data_url_simple'])->toArray();
            $invitation_data[$key]['data_url'] = $data[0]['data_url'];
            $invitation_data[$key]['data_url_simple'] = $data[0]['data_url_simple'];
        }
        $data['invitation_data'] = array_reverse($invitation_data);

        $data['show'] = '';
        //會員資料連結顯示
        $check = MemberData::where('username', $username)->get(['gender','plan'])->toArray();
        if(!empty($check)){
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
        }
        $data['username'] = $username;
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
        if($this->checkDate(3) == false){
            return redirect('/date/data');
        }
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $username = Session::get('username');
        $gender = MemberData::where('username', $username)->pluck('gender')->first();
        $data = [];
        $data['username'] = $username;
        $result = AppointmentRegistration::where('username', $username)
                            // ->whereNotNull('appointment_respond')
                            // ->whereNotIn('appointment_respond', ['noSel'])
                            ->get()
                            ->toArray();
        $result2 = AppointmentRegistration::where('appointment_user', $username)
                            // ->whereNotNull('appointment_respond')
                            // ->whereNotIn('appointment_respond', ['noSel'])
                            ->get()
                            ->toArray();  
        foreach($result2 as $key => $value){
            $result2[$key]['username'] = $value['appointment_user'];
            $result2[$key]['appointment_user'] = $value['username'];
        }  

        $res = array_merge($result,$result2);

        foreach($res as $key => $value){
            
            $phone = MemberData::where('username', $value['appointment_user'])
            ->get(['phone','give_phone'])
            ->toArray();
            
            $res[$key]['phone'] = $phone[0]['phone'] ?? '';
            $res[$key]['give_phone'] = $phone[0]['give_phone'] ?? '';

            // $message = DateMsg::where('table_id', $value['id'])->get()->toArray();
            // if(!empty($message)){
            //     if($gender == 'm'){
            //         $msg = $message[0]['f_msg'];
            //         $msg2 = $message[0]['m_msg'];
            //     }else{
            //         $msg = $message[0]['m_msg'];
            //         $msg2 = $message[0]['f_msg'];
            //     }
            // }
            $res[$key]['date_msg'] = $msg ?? '';
            $res[$key]['date_msg2'] = $msg2 ?? '';
        }  

        $data['result'] = $res;

        return view('date.show_result', [ 'data' => $data ]);
    }

    public function date_msg_post(Request $request)
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $username = Session::get('username');
        $input = $request->input();
        $gender = MemberData::where('username', $username)->pluck('gender')->first();
        $str = 'msg'.$input['table_id'];
        if($gender == 'm'){
            DateMsg::updateOrCreate(
                ['table_id' => $input['table_id']], ['m_msg' => $input[$str]]
            );
        }else{
            DateMsg::updateOrCreate(
                ['table_id' => $input['table_id']], ['f_msg' => $input[$str]]
            );
        }
    
        return redirect('/date/show_result');
    }

    public function restaurant()
    {
        if(!Session::has('username')){
            return redirect('/date/login');
        }
        $username = Session::get('username');
        $data = [];
        $data['restaurant'] = Restaurant::get(['place', 'url'])->toArray();
        $data['username'] = $username;
        return view('date.restaurant', [ 'data' => $data ]);
    }

    public function logout()
    {
        Session::forget('username');
        return redirect('/date/login');
    }

    private function checkDate($type)
    {
        $w = date('w',time());
        $H = date('H',time());
       
        if(env('TEST') == true){
            return true;
        }

        if($type == 1){
            //星期一和星期二
            if($w == 1 || $w == 2){
                return true;
            }
        }elseif($type == 2){
            //星期三和星期四
            if($w == 3 || $w == 4){
                return true;
            }
        }elseif($type == 3){
            //星期五晚上七點之後 或 週六 或 週日
            if(($w == 5 && $H >= 19 ) || $w == 6 || $w == 0){
                return true;
            }
        }else{
            return false;
        }
    }

    public function test()
    {
       
    }

}
