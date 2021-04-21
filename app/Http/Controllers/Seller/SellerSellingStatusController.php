<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\User;
use App\VerifyCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerSellingStatusController extends Controller
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
        return $this->getSellingStatus();
    }

    public function getSellingStatus() {
        $user = auth()->user();
        $sells = VerifyCode::select(DB::raw('count(*) as count'), 'type' )->whereNotNull('customer_id')->where('seller_id', $user->id)->groupBy('type')->orderBy('type')->get();
        $totals = VerifyCode::select(DB::raw('count(*) as count'), 'type' )->where('seller_id', $user->id)->groupBy('type')->orderBy('type')->get();

        $codeList = [];
        for ($i=0; $i < 3; $i++) { 
            $data = [];
            $data['selled'] = 0;
            $data['total'] = 0;
            array_push($codeList, $data);
        }

        foreach ($sells as $sell) {
            $type = $sell->type;
            $data = $codeList[$type];
            $data['selled'] = $sell->count;
            $codeList[$type] = $data;
        }

        foreach ($totals as $code) {
            $type = $code->type;
            $data = $codeList[$type];
            $data['total'] = $code->count;
            $codeList[$type] = $data;
        }

        return view('seller.sellerstatus', array('codes' => $codeList));
    }
}
