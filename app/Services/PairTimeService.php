<?php
namespace App\Services;

use App\Models\AppointmentRegistration;
use App\Models\MemberData;

class PairTimeService
{
    public function set($username)
    {
        $result = AppointmentRegistration::whereRaw("appointment_respond IS NOT NULL 
                                            AND appointment_result IS NULL 
                                            AND username = '{$username}' 
                                            ORDER BY LENGTH(appointment_respond) ASC")         
                                            ->get([
                                                'type',
                                                'username',
                                                'appointment_user',
                                                'appointment_respond',
                                                'appointment_result'
                                            ])
                                            ->toArray();

        foreach($result as $value){
            if($value['appointment_respond'] == 'delete' ||
                $value['appointment_respond'] == 'noTime' ||
                $value['appointment_respond'] == 'noSel'){
                AppointmentRegistration::where('username', $value['username'])
                    ->where('appointment_user', $value['appointment_user'])
                    ->update(['appointment_result' => $value['appointment_respond']]);
                continue;
            }

            $respond = explode("、", $value['appointment_respond']);
            foreach($respond as $val){

                $respond_time = $val;   

                if($value['type'] == '視訊約會'){
                    //檢查約人的名單中是否有占用的時間
                    $hasResult = AppointmentRegistration::where('username', $value['username'])
                            ->where('appointment_result', 'like' , "%".$respond_time."%")
                            ->first();

                    //檢查被約的名單中是否有占用的時間
                    $hasResult2 = AppointmentRegistration::where('appointment_user', $value['username'])
                            ->where('appointment_result', 'like' , "%".$respond_time."%")
                            ->first();

                    if($hasResult || $hasResult2) continue;
                }

                if($value['type'] == '餐廳約會'){
                    $respond_time2 = date('Y-m-d H:i:s', strtotime("+30 minute", strtotime($respond_time)));
                    // $respond_time3 = date('Y-m-d H:i:s', strtotime("+60 minute", strtotime($respond_time)));
                    // $respond_time4 = date('Y-m-d H:i:s', strtotime("+90 minute", strtotime($respond_time)));

                    //檢查約人的名單中是否有占用的時間
                    $hasResult = AppointmentRegistration::where('username', $value['username'])
                        ->where('appointment_result', 'like' , "%".$respond_time."%")
                        ->orwhere('appointment_result', 'like' , "%".$respond_time2."%")
                        // ->orWhere('appointment_result', 'like' , "%".$respond_time3."%")
                        // ->orWhere('appointment_result', 'like' , "%".$respond_time4."%")
                        ->first();
                    
                    //檢查被約的名單中是否有占用的時間    
                    $hasResult2 = AppointmentRegistration::where('appointment_user', $value['username'])
                        ->where('appointment_result', 'like' , "%".$respond_time."%")
                        ->orWhere('appointment_result', 'like' , "%".$respond_time2."%")
                        // ->orWhere('appointment_result', 'like' , "%".$respond_time3."%")
                        // ->orWhere('appointment_result', 'like' , "%".$respond_time4."%")
                        ->first();

                    //$respond_time = $respond_time.'、'.$respond_time2.'、'.$respond_time3.'、'.$respond_time4;

                    if($hasResult || $hasResult2) continue; 
                }

                //是否互約對方
                $hasEachOther = AppointmentRegistration::where('appointment_user', $value['username'])
                                ->where('username', $value['appointment_user'])
                                ->first();
                //排約者是男生
                $gender = MemberData::where('username', $value['username'])->pluck('gender')->first();

                if($hasEachOther && $gender == 'm'){
                    $respond_time = 'otherSide';
                } 

                AppointmentRegistration::where('username', $value['username'])
                        ->where('appointment_user', $value['appointment_user'])
                        ->update(['appointment_result' => $respond_time]);

            }

        }

        AppointmentRegistration::whereNull('appointment_respond')->update(['appointment_result' => 'no']);
    }
}