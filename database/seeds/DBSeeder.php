<?php

use Illuminate\Database\Seeder;

class DBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ary = [
            '2022-05-11 20:00:00',
            '2022-05-13 20:00:00',
            '2022-05-14 15:00:00',
            '2022-05-14 20:00:00',
            '2022-05-15 20:00:00',
            '2022-05-18 20:00:00',
            '2022-05-20 20:00:00',
            '2022-05-21 15:00:00',
            '2022-05-21 20:00:00',
            '2022-05-22 20:00:00'
        ];
        foreach($ary as $value){
            DB::table('restaurant_dates')->insert(
                ['datetime' => $value]
            );
        }

        $ary = [
            '2022-05-11 20:00:00',
            '2022-05-13 20:00:00',
            '2022-05-14 15:00:00',
            '2022-05-14 20:00:00',
            '2022-05-15 20:00:00',
            '2022-05-18 20:00:00',
            '2022-05-20 20:00:00',
            '2022-05-21 15:00:00',
            '2022-05-21 20:00:00',
            '2022-05-22 20:00:00'
        ];
        foreach($ary as $value){
            DB::table('video_dates')->insert(
                ['datetime' => $value]
            );
        }

        $ary = [
            [
                'place'=>'K.D Bistro Taipei(國父紀念館)(晚餐)(週一公休)',
                'url'=>'https://2afoodie.com/k-dbistrotaipei/',
                'qualification'=>'no'
            ],
            [
                'place'=>'Campus cafe忠孝店(忠孝復興)(下午茶&晚餐)',
                'url'=>'https://masaharuwu.pixnet.net/blog/post/66338151',
                'qualification'=>'no'
            ],
            [
                'place'=>'無聊咖啡AMBI-CAFE(忠孝敦化站)(下午茶)(晚上7點不供餐)(8點打烊)',
                'url'=>'https://www.liviatravel.com/2018/07/ambi-cafe.html',
                'qualification'=>'no'
            ],
            [
                'place'=>'Les Piccola Info.(東門站)(下午茶最晚訂位3點)(晚餐只能訂6點、6點半)(週一、週二公休)',
                'url'=>'https://lingling.blog/les-p',
                'qualification'=>'no'
            ],
            [
                'place'=>'Les Africot(東門站)(下午茶)(營業時間11點至5點)',
                'url'=>'https://www.tiffany0118.com/les-africot/',
                'qualification'=>'no'
            ],
            [
                'place'=>'BUNA CAFE布納咖啡館(內湖店&101站)(下午茶&晚餐)',
                'url'=>'https://saliha.pixnet.net/blog/post/469428374',
                'qualification'=>'no'
            ],
            [
                'place'=>'A Fabules Day(東門站)(下午茶&晚餐)',
                'url'=>'https://tenjo.tw/afabulesday/',
                'qualification'=>'no'
            ],
            [
                'place'=>'COFFEE FLAIR(中山國小站)(下午茶)',
                'url'=>'https://reurl.cc/a9mK07',
                'qualification'=>'no'
            ],
            [
                'place'=>'CIN CIN Osteria請請義大利慶城店(南京復興站)(下午茶只到4點&晚餐)',
                'url'=>'https://reurl.cc/pg0enb',
                'qualification'=>'no'
            ],
            [
                'place'=>'CIN CIN Osteria請請義大利逸仙店(國父紀念館)(下午茶只到4點&晚餐)',
                'url'=>'https://aniseblog.tw/192073',
                'qualification'=>'no'
            ],
            [
                'place'=>'誠品行旅the-chapter-cafe(松山站，下午茶&晚餐)',
                'url'=>'https://peipei.tw/the-chapter-cafe/',
                'qualification'=>'no'
            ],
            [
                'place'=>'MUGI木屐(忠孝敦化站，平日晚餐，假日中餐晚餐)',
                'url'=>'https://wing1209.pixnet.net/blog/post/47204111',
                'qualification'=>'no'
            ],
            [
                'place'=>'Muzeo餐酒館(忠孝敦化站，平日晚餐，假日中餐晚餐)',
                'url'=>'https://kenalice.tw/blog/post/muzeo',
                'qualification'=>'no'
            ],
            [
                'place'=>'木門咖啡 Wooden Door(下午茶&晚餐)',
                'url'=>'https://sunnylife.tw/wd/',
                'qualification'=>'no'
            ],
            [
                'place'=>'午街貳拾 Café Bistro(精明商圈，下午茶&晚餐)',
                'url'=>'https://mercury0314.pixnet.net/blog/post/463363799-wjno20.cafe.bistro',
                'qualification'=>'no'
            ],
            [
                'place'=>'KOI® PLUS (學士店)(下午茶&晚餐)',
                'url'=>'https://w00243413.pixnet.net/blog/post/354296875',
                'qualification'=>'no'
            ],
            [
                'place'=>'禾間糧倉(近科博館，晚餐)',
                'url'=>'https://ants.tw/middle-restro/',
                'qualification'=>'no'
            ],
            [
                'place'=>'薩克森餐酒館 Sachsen Beer Bar(近逢甲商圈，晚餐)',
                'url'=>'https://ifoodie.tw/post/5fc8af6702935e4db5fbe19d',
                'qualification'=>'no'
            ],
        ];
       
        foreach($ary as $value){
            DB::table('restaurants')->insert(
                [
                    'place' => $value['place'],
                    'url' => $value['url'],
                    'qualification' => $value['qualification'],
                ]
            );
        }

        $ary = [
            [  
                'username'=>'luke',
                'identity'=>'a123456789',
                'phone'=>'0923456789',
                'email'=>'luke@gmail.com',
                'gender'=>'m',
                'consultant'=>'sam',
                'data_url'=>'https://drive.google.com/drive/folders/luke',
                'data_url_simple'=>'https://drive.google.com/drive/folders/luke',
                'plan'=>'G',
                'live_place'=>'台北',
                'birth_place'=>'桃園',
                'record'=>'000000000000000000000000', 
            ],
            [  
                'username'=>'sam',
                'identity'=>'b123456789',
                'phone'=>'0923456788',
                'email'=>'sam@gmail.com',
                'gender'=>'m',
                'consultant'=>'sam',
                'data_url'=>'https://drive.google.com/drive/folders/sam',
                'data_url_simple'=>'https://drive.google.com/drive/folders/d/sam',
                'plan'=>'G',
                'live_place'=>'台北',
                'birth_place'=>'新北',
                'record'=>'456', 
            ],
            [  
                'username'=>'Lisa',
                'identity'=>'c123456789',
                'phone'=>'0923456787',
                'email'=>'Lisa@gmail.com',
                'gender'=>'f',
                'consultant'=>'sam',
                'data_url'=>'https://drive.google.com/drive/folders/Lisa',
                'data_url_simple'=>'https://drive.google.com/drive/folders/d/Lisa',
                'plan'=>'B',
                'live_place'=>'台北',
                'birth_place'=>'高雄',
                'record'=>'12345367867867836453', 
            ],
            [  
                'username'=>'愷妤',
                'identity'=>'d123456789',
                'phone'=>'0923456786',
                'email'=>'愷妤@gmail.com',
                'gender'=>'f',
                'consultant'=>'瑤瑤',
                'data_url'=>'https://drive.google.com/drive/folders/愷妤',
                'data_url_simple'=>'https://drive.google.com/drive/folders/d/愷妤',
                'plan'=>'C',
                'live_place'=>'台北',
                'birth_place'=>'桃園',
                'record'=>'42532753753753573', 
            ],
            [  
                'username'=>'小榆',
                'identity'=>'e123456789',
                'phone'=>'0923456785',
                'email'=>'小榆@gmail.com',
                'gender'=>'f',
                'consultant'=>'Grace',
                'data_url'=>'https://drive.google.com/drive/folders/小榆',
                'data_url_simple'=>'https://drive.google.com/drive/folders/d/小榆',
                'plan'=>'A',
                'live_place'=>'台北',
                'birth_place'=>'新竹',
                'record'=>'453737834753535435', 
            ],
            [  
                'username'=>'JC',
                'identity'=>'f123456789',
                'phone'=>'0923456784',
                'email'=>'JC@gmail.com',
                'gender'=>'f',
                'consultant'=>'Grace',
                'data_url'=>'https://drive.google.com/drive/folders/JC',
                'data_url_simple'=>'https://drive.google.com/drive/folders/d/JC',
                'plan'=>'D',
                'live_place'=>'台北',
                'birth_place'=>'台中',
                'record'=>'99999999999999999999', 
            ],
           
        ];
          
        foreach($ary as $value){
            DB::table('member_data')->insert(
                [
                    'username'   => $value['username'],
                    'identity'   => $value['identity'],
                    'phone'    => $value['phone'],
                    'email'    => $value['email'],
                    'gender'     => $value['gender'],
                    'consultant' => $value['consultant'],
                    'data_url'   => $value['data_url'],
                    'data_url_simple'   => $value['data_url_simple'],
                    'plan'   => $value['plan'],
                    'live_place'   => $value['live_place'],
                    'birth_place'   => $value['birth_place'],
                    'record'   => $value['record'],
                ]
            );
        }

        \DB::insert("
        INSERT INTO `appointment_registrations` (`id`, `username`, `type`, `chat_option`, `restaurant`, `datetime`, `appointment_user`, `appointment_respond`, `appointment_result`, `created_at`, `updated_at`) VALUES
        (1, 'luke', '餐廳約會', NULL, '禾間糧倉(近科博館，晚餐)', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', 'Lisa', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', NULL, '2022-07-23 09:09:37', '2022-07-27 09:08:36'),
        (2, 'luke', '餐廳約會', NULL, '禾間糧倉(近科博館，晚餐)', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', '愷妤', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', NULL, '2022-07-23 09:09:37', '2022-07-27 08:51:27'),
        (3, 'luke', '餐廳約會', NULL, '禾間糧倉(近科博館，晚餐)', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', '小榆', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', NULL, '2022-07-23 09:09:37', '2022-07-27 08:51:32'),
        (4, 'luke', '餐廳約會', NULL, '禾間糧倉(近科博館，晚餐)', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', 'JC', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', NULL, '2022-07-23 09:09:37', '2022-07-25 09:06:41'),
        (5, 'Lisa', '視訊約會', '自由聊天', NULL, '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00、2022-05-21 15:00:00', 'luke', '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00', NULL, '2022-07-27 08:50:09', '2022-07-27 09:08:41'),
        (6, 'Lisa', '視訊約會', '自由聊天', NULL, '2022-05-14 15:00:00、2022-05-15 20:00:00、2022-05-20 20:00:00、2022-05-21 15:00:00', 'sam', 'delete', NULL, '2022-07-27 08:50:09', '2022-07-27 09:09:07');
        ");

        \DB::insert("
        INSERT INTO `appointment_lists` (`id`, `username`, `appointment_username`, `appointment_user_new`, `appointment_user_latest`, `appointment_user_excluded`, `created_at`, `updated_at`) VALUES
        (1, 'luke', 'Lisa、愷妤、小榆、JC', '', '', NULL, '2022-07-23 09:09:09', '2022-07-25 09:05:20'),
        (2, 'Lisa', 'luke、sam', '', '', 'NULL', '2022-07-23 12:26:24', '2022-07-23 12:26:34');        
        ");

    }
}
