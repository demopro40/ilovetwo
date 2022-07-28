<?php

use Illuminate\Database\Seeder;

class DB2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //php artisan db:seed --class=DB2Seeder 

    public function run()
    {
        // \DB::insert("
        // INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
        // (2, '顧問1', '顧問', '2022-07-28 07:15:43', '2022-07-28 07:18:02');
        // ");

        // \DB::insert("
        // INSERT INTO `admin_permissions` (`name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
        // ('顧問1', '顧問', '', '/MemberData\n/AppointmentList\n/AppointmentRegistration\n/Restaurant\n/RestaurantDate\n/VideoDate', '2022-07-28 08:00:38', '2022-07-28 08:02:24');        
        // ");
        
        // $str = '$2y$10$E9rJ2QTk5aNhmXlokJuwsep5zpLorIoc2ZFz3pHKrt0YIxotzcgPq';
        // \DB::insert("
        // INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
        // (2, 'sam', '{$str}', '顧問sam', NULL, 'VbbyfcKEEqrRWq9dU4ZsB2MM9Gm9GcKPbpJyOr8yQZE4oDiQhMbsQeLhSZj6', '2022-07-28 07:16:48', '2022-07-28 08:06:05');        
        // ");

        
    }
}
