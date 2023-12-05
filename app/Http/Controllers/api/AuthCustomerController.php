<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\UserResource;
use App\Mail\SendCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthCustomerController extends BaseController
{
    //login store template
//login store with phoneNumber template
    public function login_customer(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'phonenumber' => ['required', 'numeric', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/',
            ],

        ]);
        if ($validator->fails()) {
            return $this->sendError(null, $validator->errors());
        }

        if (is_null(User::where('phonenumber', $request->phonenumber)->where('user_type', 'customer')->where('is_deleted', 0)->first())) {

            $validator = Validator::make($input, [
                'phonenumber' => ['required', 'numeric', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', Rule::unique('users')->where(function ($query) {
                    return $query->where('user_type', 'customer');
                }),
                ],

            ]);
            if ($validator->fails()) {
                return $this->sendError(null, $validator->errors());
            }

            $user = User::create([
                'phonenumber' => $request->phonenumber,
                'user_type' => "customer",
            ]);

            $user->generateVerifyCode();
            $request->code = $user->verify_code;
            $request->phonenumber = $user->phonenumber;
            $this->sendSms($request);

        } else {
            $user = User::where('phonenumber', $request->phonenumber)->where('user_type', 'customer')->where('is_deleted', 0)->first();
            $user->generateVerifyCode();
            $request->code = $user->verify_code;
            $request->phonenumber = $user->phonenumber;
            $this->sendSms($request); // send and return its response

        }

        $success['user'] = new UserResource($user);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم تسجيل الدخول بنجاح', 'Login Successfully');

    }

    //login store with email template
    public function login_customer_email(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => ['required', 'email',
            ],
        ]);
        if ($validator->fails()) {
            return $this->sendError(null, $validator->errors());
        }

        if (is_null(User::where('email', $request->email)->where('user_type', 'customer')->where('is_deleted', 0)->first())) {
            $validator = Validator::make($input, [
                'email' => ['required', 'email', Rule::unique('users')->where(function ($query) {
                    return $query->where('user_type', 'customer');
                }),
                ],
            ]);
            if ($validator->fails()) {
                return $this->sendError(null, $validator->errors());
            }

            $user = User::create([
                'email' => $request->email,
                'user_type' => "customer",
            ]);
            $user->generateVerifyCode();
            $request->code = $user->verify_code;
            $request->email = $user->email;
            $data = array(
                'code' => $request->code,
            );

            Mail::to($user->email)->send(new SendCode($data));

        } else {
            $user = User::where('email', $request->email)->where('user_type', 'customer')->where('is_deleted', 0)->first();

            $user->generateVerifyCode();
            $request->code = $user->verify_code;
            $data = array(
                'code' => $request->code,
            );

            //  $request->phonenumber = $user->phonenumber;
            Mail::to($user->email)->send(new SendCode($data));

        }

        $success['user'] = new UserResource($user);
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

    public function verifyUser(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'phonenumber' => 'required|string',
            'code' => 'required|numeric',
        ], [
            'phonenumber.required' => 'المدخل مطلوب',
        ]);

        if ($validator->fails()) {
            # code...
            return $this->sendError(null, $validator->errors());
        }

        $user = User::where('user_type', 'customer')->where('phonenumber', $request->phonenumber)->orWhere('email', $request->phonenumber)->where('is_deleted', 0)->latest()->first();
        if (is_null($user)) {

            return $this->sendError('الحساب غير موجود', 'User not found');
        }

        if ($request->code == $user->verify_code) {

            $user->resetVerifyCode();
            $user->verified = 1;
            $user->save();
            $success['status'] = 200;
            $success['user'] = new UserResource($user);
            if (is_null($user->phonenumber) || is_null($user->email)) {
                $success['token'] = null;
            } else {
                $success['token'] = $user->createToken('authToken')->accessToken;
            }
            return $this->sendResponse($success, 'تم التحقق', 'verified');
        } else {
            $success['status'] = 200;
            return $this->sendResponse($success, 'لم يتم التحقق', 'not verified');
        }
    }

    public function registerUser(Request $request, $id)
    {
        $user = User::where('id', $id)->where('is_deleted', 0)->first();
        if ($user->phonenumber != null) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string',
                //  'user_name' =>  ['required', 'string','max:255', Rule::unique('users')->where(function ($query) {
                //     return $query->where('user_type','customer')->where('is_deleted',0);
                // })],
                'user_name' => 'nullable',
                'lastname' => 'nullable|string',
                'email' => ['required', 'email', Rule::unique('users')->where(function ($query) {
                    return $query->where('user_type', 'customer')->where('is_deleted', 0);
                }),
                ],
            ]);
            if ($validator->fails()) {
                # code...
                return $this->sendError(null, $validator->errors());
            }
            $user->update([
                'name' => $request->name,
                // 'user_name' => $request->user_name,
                'lastname' => $request->lastname,
                'email' => $request->email,

            ]);
        } else {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string',
                // 'user_name' =>  ['required', 'string','max:255', Rule::unique('users')->where(function ($query) {
                //     return $query->where('user_type', 'customer')->where('is_deleted',0);
                // })],
                'user_name' => 'nullable',
                'lastname' => 'required|string',
                'phonenumber' => ['required', 'numeric', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', Rule::unique('users')->where(function ($query) {
                    return $query->where('user_type', 'customer')->where('is_deleted', 0);
                }),
                ],

            ]);

            if ($validator->fails()) {
                # code...
                return $this->sendError(null, $validator->errors());
            }
            $user->update([
                'name' => $request->name,
                // 'user_name' => $request->user_name,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,

            ]);
        }
        $success['status'] = 200;
        $success['user'] = new UserResource($user);
        $success['token'] = $user->createToken('authToken')->accessToken;
        return $this->sendResponse($success, 'تم التسجيل', 'regsiter');
    }

    public function sendSms($request)
    {

        try
        {
            $data_string = json_encode($request);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://rest.gateway.sa/api/SendSMS',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
        "api_id":"' . env("GETWAY_API", null) . '",
        "api_password":"' . env("GETWAY_PASSWORD", null) . '",
        "sms_type": "T",
        "encoding":"T",
        "sender_id": "ATLBHA",
        "phonenumber": "' . $request->phonenumber . '",
        "textmessage":"' . $request->code . '",

  	"templateid": "1868",
  	"V1": "' . $request->code . '",
  	"V2": null,
  	"V3": null,
  	"V4": null,
  	"V5": null,
"ValidityPeriodInSeconds": 60,
"uid":"xyz",
"callback_url":"https://xyz.com/",
"pe_id":"xyz",
"template_id":"1868"


        }
        ',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);

            /*  curl_close($curl);
            echo $response;

            $ch = curl_init('http://REST.GATEWAY.SA/api/SendSMS?api_id=API71257826714&api_password=FAZ@102030@123&sms_type=P&encoding=T&sender_id=MASHAHER&phonenumber='.$request->phonenumber.'&textmessage='.$request->code.'&uid=xyz&callback_url=null');

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($data_string))
            );
            $result = curl_exec($ch);*/
            $decoded = json_decode($response);

//dd($decoded);
            if ($decoded->status == "S") {
                return true;
            }

            return $this->sendError("فشل ارسال الرسالة", "Failed Send Message");

        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
