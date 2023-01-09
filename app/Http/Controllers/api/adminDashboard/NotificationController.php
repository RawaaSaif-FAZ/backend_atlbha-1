<?php

namespace App\Http\Controllers\api\adminDashboard;
use Carbon\Carbon;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;

class NotificationController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $success['count_of_notifications']=auth()->user()->Notifications->count();
        $success['notifications']=auth()->user()->Notifications;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع جميع الاشعارات بنجاح','Notifications return successfully');
    }
    public function read($id){
       
        $userUnreadNotification =  Notification::query()->find($id);
        $userUnreadNotification->update(['read_at' =>Carbon::now()]);
    
        $success['notifications']=$userUnreadNotification;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع  الاشعار بنجاح','Notifications return successfully');
    }
}
