<?php

use Illuminate\Database\Seeder;

class DB2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ary = [
            [
                'parent_id'=>'0',
                'order'=>'8',
                'title'=>'推播系統',
                'icon'=>'fa-bars',
                'uri'=>'',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'9',
                'title'=>'會員資料',
                'icon'=>'fa-bars',
                'uri'=>'/MemberData',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'10',
                'title'=>'會員推播表',
                'icon'=>'fa-bars',
                'uri'=>'/AppointmentList',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'11',
                'title'=>'排約報名表',
                'icon'=>'fa-bars',
                'uri'=>'/AppointmentRegistration',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'12',
                'title'=>'餐廳地點設定',
                'icon'=>'fa-bars',
                'uri'=>'/Restaurant',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'13',
                'title'=>'餐廳約會時間設定',
                'icon'=>'fa-bars',
                'uri'=>'/RestaurantDate',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'14',
                'title'=>'視訊約會時間設定',
                'icon'=>'fa-bars',
                'uri'=>'/VideoDate',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'15',
                'title'=>'上傳檔案',
                'icon'=>'fa-bars',
                'uri'=>'/Upload',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'16',
                'title'=>'其他',
                'icon'=>'fa-bars',
                'uri'=>'/Other',
                'permission'=>null,
            ],
        ];
        foreach($ary as $value){
            DB::table('admin_menu')->insert(
                [
                    'parent_id' => $value['parent_id'],
                    'order' => $value['order'],
                    'title' => $value['title'],
                    'icon' => $value['icon'],
                    'uri' => $value['uri'],
                    'permission' => $value['permission'],
                ]
            );
        }

        //密碼:472rht6syuygmgwa
        //密碼:rhyc2w5qvrasz5wz
        //密碼:97dzkhmcwaxveujk
        $password0 = '$2y$10$KVZ6i4by5jZ.4gm5xT5K0Ojs52mpOwnW14nueei3DUMN2qZRN4aJu';
        $remember_token0 = 'sNMxAp4bi5g7jkoVj0Zpv5DCyZEB4s2XZzfaTssKk8EOq9a6rlv7aNLcopmP';
        $password = '$2y$10$sqwDNw0z0kAj8phxepOIneb3h8PcQ/UuGnAh4hxKV/8YVI6E.kabG';
        $remember_token = 'lxmx51XPDhcOybxr7uv0MnCxHQ2s7I52BwWLbvn2U9Sk4ShWnynNybrNfkvI';
        $password2 = '$2y$10$o/P/.uPY4qbUL0H1DCUOAuwUIcXuGHsxLe5ZEvQ99.IsgriSPzXTe';
        $remember_token2 = 'VbbyfcKEEqrRWq9dU4ZsB2MM9Gm9GcKPbpJyOr8yQZE4oDiQhMbsQeLhSZj6';

        \DB::update("update `admin_users` set password = '{$password0}',`remember_token` = '{$remember_token0}' where 1 = 1");

        \DB::insert("
        INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`) VALUES
        (2, 'sam', '{$password}', 'sam', NULL, '{$remember_token}'),
        (3, 'lan', '{$password2}', 'lan', NULL, '{$remember_token2}')             
        ;");

        \DB::insert("
        INSERT INTO `admin_role_users` (`role_id`, `user_id`) VALUES
        (2,2),
        (2,3)                 
        ;");

        \DB::insert("
        INSERT INTO `admin_roles` (`id`, `name`, `slug`) VALUES
        (2, '顧問1', '顧問');
        ");

        \DB::insert("
        INSERT INTO `admin_permissions` (`name`, `slug`, `http_method`, `http_path`) VALUES
        ('顧問1', '顧問', '', '/MemberData*\n/AppointmentList*\n/AppointmentRegistration*\n/Restaurant*\n/RestaurantDate*\n/VideoDate*');        
        ");

        \DB::insert("
        INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`) VALUES
        (2,2),
        (2,6)              
        ;");


    }
}
