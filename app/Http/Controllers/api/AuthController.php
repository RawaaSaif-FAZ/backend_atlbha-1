<?php

namespace App\Http\Controllers\api;

use Str;
use App\Models\User;
use App\Models\Store;
use App\Models\Marketer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class AuthController extends BaseController
{
    protected $code;

    public function register(Request $request)
    {
        $input = $request->all();
        $validator =  Validator::make($input ,[
            'user_type'=>'required|in:store,marketer',
            'user_name'=>'required|string|max:255',
            'store_name'=>'required_if:user_type,store|string|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'domain'=>'required_if:user_type,store|url',
            'userphonenumber' =>['required','numeric','regex:/^(009665|9665|\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
            'phonenumber' =>['required_if:user_type,store','numeric','regex:/^(009665|9665|\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
            'activity_id' =>'required|array|exists:activities,id',
            'package_id' =>'required_if:user_type,store|exists:packages,id',
            'country_id'=>'required_if:user_type,store|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'periodtype'=>'required|in:6months,year',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if($request->user_type=="store"){
            $user = User::create([
                'name' => $request->user_name,
                'email'=>$request->email,
                'user_name' => $request->user_name,
                'user_type' => "store",
                'password'=>$request->password,
                'userphonenumber' => $request->phonenumber,
            ]);

            $userid =$user->id;


            $store = Store::create([
                'store_name' => $request->store_name,
                'store_email'=>$request->email,
                'domain' =>$request->domain,
                'phonenumber' => $request->phonenumber,
                'package_id' => $request->package_id,
                'user_id' => $userid,
                'periodtype'=>$request->periodtype,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id
            ]);

            $user->update([
                'store_id' =>  $store->id]);

            if($request->periodtype =="6months"){
            $end_at = date('Y-m-d',strtotime("+ 6 months", strtotime($store->created_at)));
            $store->update([
                'start_at'=> $store->created_at,
                    'end_at'=>  $end_at ]);
            }
            else{
                $end_at = date('Y-m-d',strtotime("+ 1 years", strtotime($store->created_at)));
            $store->update([
                'start_at'=> $store->created_at,
                    'end_at'=>  $end_at ]);

                }
            $store->activities()->attach($request->activity_id);
            $store->packages()->attach( $request->package_id,['start_at'=> $store->created_at,'end_at'=>$end_at,'periodtype'=>$request->periodtype,'packagecoupon_id'=>$request->packagecoupon]);

        }
        else{
            $marketer = Marketer::create([
                'name'=> $request->user_name,
                'user_name'=> $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
                'phonenumber' => $request->phonenumber,
                'city_id' =>$request->city_id,
            ]);
            $user = User::create([
                'name'=> $request->user_name,
                'user_name'=> $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
                'phonenumber' => $request->phonenumber,
                'city_id' =>$request->city_id,
               'user_type' => "marketer",
            ]);
        }


        $success['user'] = new UserResource($user);
        $success['token'] = $user->createToken('authToken')->accessToken;
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم تسجيل الدخول بنجاح', 'Login Successfully');
}

    public function login(Request $request)
    {
        $input = $request->all();
        $validator =  Validator::make($input, [
            'user_name' => 'string|required',
            'password' => 'string|required',
            'device_token' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(null, $validator->errors());
        }
            //dd(Hash::make($request->password));

        if (
            !auth()->guard()->attempt(['email' => $request->user_name, 'password' => $request->password])
            && !auth()->guard()->attempt(['user_name' => $request->user_name, 'password' => $request->password])
        ) {
            return $this->sendError('خطأ في اسم المستخدم أو كلمة المرور', 'Invalid Credentials');
        } elseif (
            !auth()->guard()->attempt(['email' => $request->user_name, 'password' => $request->password, 'verified' => 1])
            && !auth()->guard()->attempt(['user_name' => $request->user_name, 'password' => $request->password, 'verified' => 1])
        ) {
            $user = User::where('user_name', $request->user_name)->orWhere('email', $request->user_name)->first();

            if ($user) {

                $user->generateVerifyCode();
                $request->code = $user->verify_code;
                $request->phonenumber = $user->phonenumber;
                $this->sendSms($request); // send and return its response
            }

            return $this->sendError('الحساب غير محقق', 'User not verified');
        }


        $user = auth()->user();

        $user->update(['device_token' => $request->device_token]);

        $success['user'] = new UserResource($user);
        $success['token'] = $user->createToken('authToken')->accessToken;
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم تسجيل الدخول بنجاح', 'Login Successfully');
    }


    public function logout()
    {
        $user = auth("api")->user()->token();
        $user->revoke();

        $success['status'] = 200;
        return $this->sendResponse($success, 'تم تسجيل الخروج بنجاح', 'User logout Successfully');
    }



    public function store_verify_message(Request $request)
    {
        $input = $request->all();
        $validator =  Validator::make($input, [
            'user_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            # code...
            return $this->sendError($validator->errors());
        }

        $user = User::where('user_name', $request->user_name)->orWhere('email', $request->user_name)->first();
        if (!$user) {
            return $this->sendError('المستخدم غير موجود', 'We cant find a user with that user_name.');
        }


        if ($user) {
            $user->generateVerifyCode();

            $request->code = $user->verify_code;
            $request->phonenumber = $user->phonenumber;
            $this->sendSms($request); // send and return its response

        }

        $success['status'] = 200;
        $success['user'] = new UserResource($user);
        return $this->sendResponse($success, 'تم ارسال الرسالة بنجاح', 'Email send successfully');
    }

    public function verifyUser(Request $request)
    {

        $input = $request->all();
        $validator =  Validator::make($input, [
            'user_name' => 'required|string',
            'code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            # code...
            return $this->sendError(null, $validator->errors());
        }


        $user = User::where('user_name', $request->user_name)->orWhere('email', $request->user_name)->latest()->first();

        if ($request->code == $user->verify_code) {
            $user->resetVerifyCode();
            $user->verified = 1;
            $user->save();
            $success['status'] = 200;
            $success['user'] = new UserResource($user);
            $success['token'] = $user->createToken('authToken')->accessToken;
            return $this->sendResponse($success, 'تم التحقق', 'verified');
        } else {
            $success['status'] = 200;
            return $this->sendResponse($success, 'لم يتم التحقق', 'not verified');
        }
    }






    /////////////////////////////////////////////////// SMS


    public function sendSms($request)
    {

        try {
            $ch = curl_init('https://el.cloud.unifonic.com/rest/SMS/messages?AppSid=hDRvlqGVdSQwsCLPk0bDRJIqs9Vvdi&SenderID=MASHAHER&Body=' . $request->code . '&Recipient=' . $request->phonenumber);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded'
                )
            );
            $result = curl_exec($ch);
            $decoded = json_decode($result);
            if ($decoded->success == "true") {
                return true;
            }

            return $this->sendError("فشل ارسال الرسالة", "Failed Send Message");
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function social_mobile(Request $request)
    {
        $input = $request->all();
        $validator =  Validator::make($input, [
            'user_name' => 'string|required',
            'device_token' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(null, $validator->errors());
        }

        $user = User::where('email', $request->user_name)->first();
        if (is_null($user)) {
            return $this->sendError('خطأ في اسم المستخدم ', 'Invalid Credentials');
        } elseif ($user->verified == 0) {
            $user = User::where('email', $request->user_name)->first();

            if ($user) {
                $user->generateVerifyCode();
                $request->code = $user->verify_code;
                $request->phonenumber = $user->phonenumber;

                $this->sendSms($request); // send and return its response
            }

            return $this->sendError('الحساب غير محقق', 'User not verified');
        }

        $user = Auth::guard('web')->loginUsingId($user->id, true);
        $user->update(['device_token' => $request->device_token]);

        $success['user'] = new UserResource($user);
        $success['token'] = $user->createToken('authToken')->accessToken;
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم تسجيل الدخول بنجاح', 'Login Successfully');
    }
}
