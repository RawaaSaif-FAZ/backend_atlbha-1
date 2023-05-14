<?php

namespace Database\Seeders;
use Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Notifications\verificationNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $data=[
            'message' => 'تم تفعيل وسيلة دفع جديدة',
            'store_id' =>1,
            'user_id'=>1,
            'type'=>"store_payment",
            'object_id'=>1
        ];
      $data1=[
        'message' => 'تم تفعيل وسيلة دفع جديدة',
        'store_id' =>1,
            'user_id'=>1,
            'type'=>"store_payment",
            'object_id'=>1
        ];
        $user = User::where('store_id',1)->first();
        Notification::send($user, new verificationNotification($data));
        Notification::send($user, new verificationNotification($data1));
    }
}
