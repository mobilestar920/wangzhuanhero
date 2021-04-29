<?php

namespace App\Http\Controllers\Manager;

use App\Customer;
use App\Http\Controllers\Controller;
use App\VerifyCode;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ManageCustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the customer list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->getCustomers();
    }

    public function getCustomers() {
        $users = Customer::where('id', '>' , -1)->get();
        $userList = [];
        foreach ($users as $user) {
            $data = [];
            $data['id'] = $user->id;
            $data['code'] = $user->code;
            $data['phone'] = $user->phone;
            $data['device_uuid'] = $user->device_uuid;

            $createDate = new DateTime($user->created_at);
            $createDate->setTimezone(new DateTimeZone('Asia/Shanghai'));
            $data['created_at'] = $createDate->format("Y/m/d H:i:s");

            $expireDate = new DateTime($user->expire_at);
            $expireDate->setTimezone(new DateTimeZone('Asia/Shanghai'));
            $data['expire_at'] = $expireDate->format("Y/m/d H:i:s");


            $verification_code = VerifyCode::where('customer_id', $user->id)->orderBy('updated_at', 'desc')->first();
            if ($verification_code == null) {
                $data['verification_code'] = "";
            } else {
                $data['verification_code'] = $verification_code->code;
            }
                        
            array_push($userList, $data);
        }

        return view('manager.customers', array('users' => $userList));
    }

}
