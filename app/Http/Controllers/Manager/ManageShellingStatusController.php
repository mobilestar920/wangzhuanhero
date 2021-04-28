<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\User;
use App\VerifyCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageShellingStatusController extends Controller
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
        $user = auth()->user();
        if ($user->role != 0) {
            return redirect('/logout'); 
        }

        return $this->getSellingStatus();
    }

    public function getSellingStatus() {
        $sells = VerifyCode::select(DB::raw('count(*) as count'), 'type' )->whereNotNull('customer_id')->groupBy('type')->orderBy('type')->get();
        $totals = VerifyCode::select(DB::raw('count(*) as count'), 'type' )->groupBy('type')->orderBy('type')->get();
        
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

        return view('manager.sellings', array('codes' => $codeList));
    }

    public function showDetail($type) {
        $user = auth()->user();
        if ($user->role != 0) {
            return redirect('/logout'); 
        }

        $totals = VerifyCode::select(DB::raw('count(*) as count'), 'seller_id')->where('type', $type)->groupBy('seller_id')->orderBy('seller_id')->get();
            
        $userList = [];
        foreach ($totals as $total) {
            $seller = User::where('id', $total->seller_id)->first();
            $total_count = $total->count;

            $sells = VerifyCode::where('type', $type)->where('seller_id', $total->seller_id)->whereNotNull('customer_id')->count();
        
            $data = [];
            $data['username'] = $seller->username;
            $data['total'] = $total_count;
            $data['selled'] = $sells;

            array_push($userList, $data);
        }

        return view('manager.selling_seller', array('sellers' => $userList, 'type' => $type));
    }
}
