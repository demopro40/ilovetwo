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

        //密碼:123123
        $password = '$2y$10$u3gVb8n5.pscT0Z55hWKJ.emBtsVzlvUDPdF2dzPeiTelTwVoFjru';
        $remember_token = 'VbbyfcKEEqrRWq9dU4ZsB2MM9Gm9GcKPbpJyOr8yQZE4oDiQhMbsQeLhSZj6';
        $password2 = '$2y$10$pwdWcYIcbJT4Z7WLLMyyLOQZHbH5f/z/JxuiQqptUM/p982b.xvRS';
        $remember_token2 = 'VbbyfcKEEqrRWq9dU4ZsB2MM9Gm9GcKPbpJyOr8yQZE4oDiQhMbsQeLhSZj6';
        \DB::insert("
        INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`) VALUES
        (2, 'sam', '{$password}', 'sam', NULL, '{$remember_token}'),
        (3, '小嵐', '{$password2}', '小嵐', NULL, '{$remember_token2}')             
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
