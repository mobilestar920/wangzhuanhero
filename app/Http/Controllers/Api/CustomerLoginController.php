<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Customer;
use App\Http\Controllers\Api\UserRegisterRequest;
use App\MyApps;
use App\News;
use App\User;
use App\VerifyCode;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerLoginController extends Controller
{
    /**
     * User Login
     * 
     * @method POST
     * 
     * @param request - user's phone number, password, device uuid
     * 
     * @return response - success : Bool, message: String, token: bearer token for authorization
     */
    public function login(UserRegisterRequest $request)
    {

        $response = [];

        $imei    = $request->device_uuid;
        $phone   = $request->phone;
        $password = $request->password;
        $verify_code = $request->verify_code;
        $news_id    = $request->news_id;

        $current = Carbon::now();
        $user = Customer::where('phone', $phone)->first();
                
        // User Request With Verify Code
        if ($verify_code != null) {
            $verifyCode = VerifyCode::where('code', $verify_code)->first();

            if ($verifyCode == null) {
                return response()->json(['success' => false, 'message' => '验证码不正确.']);
            } else if ($verifyCode->rSeller->is_blocked) {
                return response()->json(['success' => false, 'message' => '验证码不正确']);
            }

            $availableDays = 0;
            if ($verifyCode->type == 0) {
                $availableDays = 7;
            } else if ($verifyCode->type == 1) {
                $availableDays = 15;
            } else {
                $availableDays = 30;
            }

            // New Verification Code
            if ($verifyCode->customer_id == null) {
                // If User has alredy exist
                if ($user != null) {
                    if ($password != $user->password) {
                        return response()->json(['success' => false, 'message' => '密码错误.']);
                    }

                    $codeUsing = VerifyCode::where('customer_id', $user->id)->orderBy('updated_at', 'desc')->first();

                    // Delete Previous Code
                    if ($codeUsing != null) {
                        $codeUsing->is_deleted = 1;
                        $codeUsing->save();
                    }

                    $user->expire_at = $user->expire_at->addDays($availableDays);

                // If User doesn't exist, register user
                } else {
                    $user_count = Customer::where('id', '>', '-1')->count() + 1;
                    $str_length = 5;
                    $code = 'XCS' . substr("0000{$user_count}", -$str_length);

                    $user = new Customer();
                    $user->code = $code;
                    $user->phone = $phone;
                    $user->password = $password;
                    $user->expire_at = $user->expire_at->addDays($availableDays + 1);
                }

                // User Info Update
                $user->device_uuid = $imei;
                $user->save();

                // Assign New Verification Code
                $verifyCode->customer_id = $user->id;
                $verifyCode->save();

            // Verification already assigned
            } else {
                // If User doesn't exist
                if ($user == null) {
                    return response()->json(['success' => false, 'message' => '验证码不正确.']);
                }

                if ($password != $user->password) {
                    return response()->json(['success' => false, 'message' => '密码错误.']);
                }

                // Verification does't assigned to user
                if ($verifyCode->customer_id != $user->id) {
                    return response()->json(['success' => false, 'message' => '验证码不正确.']);
                }

                // Verification code expired
                if ($current > $user->expire_at) {
                    $verifyCode->is_deleted = 1;
                    $verifyCode->save();

                    return response()->json(['success' => false, 'message' => '使用期限已满。']);
                }

                $user->device_uuid = $imei;
                $user->save();
            }

        // User request without verification code
        } else {
            // User already exist
            if ($user != null) {
                if ($password != $user->password) {
                    return response()->json(['success' => false, 'message' => '密码错误.']);
                }

                $codeUsing = VerifyCode::where('customer_id', $user->id)->orderBy('updated_at', 'desc')->first();
                // If user has verification code
                if ($codeUsing != null) {
                    return response()->json(['success' => false, 'message' => '请输入验证码.']);
                }

                // If user free and expired free trial
                if ($current > $user->expire_at) {
                    return response()->json(['success' => false, 'message' => '使用期限已满。']);
                }

                $expire_at = $user->expire_at;
            } else {
                $user_count = Customer::where('id', '>', '-1')->count() + 1;
                $str_length = 5;
                $code = 'XCS' . substr("0000{$user_count}", -$str_length);

                $user = new Customer();
                $user->code = $code;
                $user->phone = $phone;
                $user->password = $password;
                $user->expire_at = $current->addDays(1);
            }

            $user->device_uuid = $imei;
            $user->save();
        }

        $token = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addDays(7)->timestamp]);

        $data = [];
        $data['id'] = $user->id;
        $data['user_code'] = $user->code;
        $data['device_uuid'] = $user->device_id;
        $data['phone'] = $user->phone;

        $data['updated_at'] = $user->updated_at;
        $data['expire_at'] = $user->expire_at;
        $data['note'] = $user->note;

        $datetime1 = new DateTime($user->expire_at);
        $datetime2 = new DateTime($current);
        $interval = $datetime2->diff($datetime1);
        $days = $interval->format('%a'); //now do whatever you like with $days
        $data['remain_days'] = $days;

        $key = env('XCS_SECRET', 'LbGqH750ukm7g2fbWqzDbQ5L');
        $iv = env('XCS_IV', 'jefQJhKG');
        $ENCR_KEY = env('XCS_KEY', 'U8gU2JVDvWjUDIGFHwqHgFjz');

        $encrypt = openssl_encrypt($key, "des-ede3-cbc", $ENCR_KEY, OPENSSL_RAW_DATA, $iv);

        // Get Current App Status
        //
        $caishen = MyApps::where('id', '>', -1)->orderBy('version', 'desc')->first();
        if ($caishen == null) {
            return response()->json(['success' => false, 'message' => 'No version available for now']);
        }

        // Get Latest News
        //
        $condition = News::where('id', '>', -1);
        if ($news_id != null) {
            $condition = $condition->where('id', '>', $news_id);
        }

        $news = $condition->orderBy('created_at', 'desc')->first();

        $response['success'] = true;
        $response['token'] = $token;
        $response['user'] = $data;
        $response['version'] = $caishen;
        $response['signature'] = base64_encode($encrypt);

        if ($news != null) {
            $response['news'] = $news;
        }

        return response()->json($response);
    }
}