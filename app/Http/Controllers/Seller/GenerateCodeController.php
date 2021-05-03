<?php

namespace App\Http\Controllers\Seller;

use App\Exports\VerifyCodeExport;
use App\Http\Controllers\Controller;
use App\User;
use App\VerifyCode;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GenerateCodeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->getVerificationCode(0);
    }

    public function getVerificationCode($type)
    {
        $user = auth()->user();
        $codes = VerifyCode::where('type', $type)->where('seller_id', $user->id)->whereNull('customer_id')->get();
        $codeList = [];
        foreach ($codes as $code) {
            $data = [];
            $data['code'] = $code->code;

            $createDate = new DateTime($code->created_at);
            $createDate->setTimezone(new DateTimeZone('Asia/Shanghai'));
            $data['created_at'] = $createDate->format("Y/m/d H:i:s");
            array_push($codeList, $data);
        }

        return view('seller.generation', array('codes' => $codeList));
    }

    public function generateCode(Request $request)
    {
        $user = auth()->user();
        if ($user->is_blocked == 1) {
            session()->flash('message', 'You are banned by admin');
            return redirect()->route('logout');
        }


        $type = $request->code_type;
        $count = $request->code_count;

        $n = 0;
        while (true) {
            if ($n >= intval($count)) {
                break;
            }

            $rand_code = $this->generateRandomString();
            $code = VerifyCode::where('code', $rand_code)->first();
            if ($code == null) {
                $code = new VerifyCode();
                $code->code = $rand_code;
                $code->type = $type;
                $code->seller_id = $user->id;
                $code->save();

                $n++;
            }
        }

        return redirect('/generation');
    }

    function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function exportToExcel()
    {
        $user = auth()->user();
        $export = new VerifyCodeExport($user->id);
        Excel::store($export, 'verificationCodes.xlsx');
        return Excel::download($export, 'verificationCodes.xlsx');
    }
}
