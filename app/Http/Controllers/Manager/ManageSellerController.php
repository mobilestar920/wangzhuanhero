<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ManageSellerController extends Controller
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
        return $this->getSellers();
    }

    public function getSellers() {
        $users = User::where('role', 1)->get();

        $userList = [];
        foreach ($users as $user) {
            $data = [];
            $data['id'] = $user->id;
            $data['username'] = $user->username;
            $data['email'] = $user->email;
            $data['is_blocked'] = $user->is_blocked;
            $data['created_at'] =date_format($user->created_at,"Y/m/d");
            
            array_push($userList, $data);
        }

        return view('manager.sellers', array('users' => $userList));
    }

    public function blockSeller(Request $request) {
        $user_id = $request->user_id;
        $is_block = $request->is_block;
        $user = User::where('id', $user_id)->first();
        if ($user != null) {
            $user->is_blocked = $is_block;
            $user->save();

            return response()->json(['success'=>true, 'message'=>'State is changed successfully.']);
        } else {
            return response()->json(['success'=>false, 'message'=>'User does not exist.']);
        }
    }
}
