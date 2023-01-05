<?php

namespace App\Http\Controllers\api\storeDashboard;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\activities_stores;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController as BaseController;

class VerificationController extends BaseController
{

       public function __construct()
    {
        $this->middleware('auth:api');
    }
     public function verification_show()
    {
        $success['activity']=activities_stores::where('store_id',auth()->user()->store_id)->pluck('activity_id')->first();
        $type=Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->pluck('commercialregistertype')->first();
        if($type == 'maeruf'){
           $success['name']=Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->pluck('name')->first();
           $success['city']=Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->pluck('city_id')->first();

        }
        elseif($type == 'commercialregister'){
        $success['city']=Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->pluck('city_id')->first();
        $success['link']=Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->pluck('link')->first();
        }
        $success['file']=Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->pluck('file')->first();
        $success['status']= 200;

         return $this->sendResponse($success,'تم عرض بيانات النوثيق بنجاح','verifiction shown successfully');
    }


    public function verification_update(Request $request)
    {
        $input = $request->all();
        $validator =  Validator::make($input ,[
           'activity_id' =>'required|array',
           'commercialregistertype'=>'required|in:commercialregister,maeruf',
           'store_name'=>'required_if:commercialregistertype,commercialregister',
           'city_id'=>'required',
           'link'=>'required_if:commercialregistertype,maeruf',
           'file'=>'required|mimes:pdf,doc,excel',
            'name'=>'required|string|max:255',
            'phonenumber' =>['required','numeric','regex:/^(009665|9665|\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
        ]);
        if ($validator->fails())
        {
           # code...
           return $this->sendError(null,$validator->errors());
        }
        $store = Store::where('is_deleted',0)->where('id',auth()->user()->store_id)->first();

  if ($store->verification_status=="admin_waiting"|| $store->verification_status=="accept"){
            return $this->sendError("الطلب قيد المراجعه","request is in process");
            }

        $store->update([
            'commercialregistertype' =>  $request->input('commercialregistertype'),
            'store_name' =>  $request->input('store_name'),
            'city_id' =>  $request->input('city_id'),
            'link' =>  $request->input('link'),
            'file' =>  $request->input('file'),
            'phonenumber' =>  $request->input('phonenumber'),

        ]);
         $store->activities()->sync($request->activity_id);
       $user = User::where('is_deleted',0)->where('store_id',auth()->user()->store_id)->first();
       $user->update([
         'name' =>  $request->input('name'),
         ]);
        $success['store']=store::where('is_deleted',0)->where('id',auth()->user()->store_id)->first();
        $success['status']= 200;

         return $this->sendResponse($success,'تم تعديل الاعدادات بنجاح','registration_status update successfully');
    }
}

