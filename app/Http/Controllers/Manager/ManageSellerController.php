<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use DateTimeZone;
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
        $user = auth()->user();
        if ($user->role != 0) {
            return redirect('/logout'); 
        }

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

            $createDate = new DateTime($user->created_at);
            $createDate->setTimezone(new DateTimeZone('Asia/Shanghai'));
            $data['created_at'] =$createDate->format("Y/m/d H:i:s");
            
            array_push($userList, $data);
        }

        return view('manager.sellers', array('users' => $userList));
    }

    public function blockSeller(Request $request) {
        $user = auth()->user();
        if ($user->role != 0) {
            return redirect('/logout'); 
        }
        
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
