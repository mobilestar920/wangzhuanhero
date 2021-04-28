<?php

namespace App\Http\Controllers\Manager;

use App\AppResources;
use App\Apps;
use App\AppScript;
use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ManageScriptController extends Controller
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

        $cond = AppScript::where('id', '>', -1);
        $resources = $cond->get();

        $appIds = [];
        $resourceList = [];
        foreach ($resources as $resource) {
            $data = [];
            $data['id'] = $resource->id;
            $data['app_id'] = $resource->app_id;
            $data['name'] = $resource->rApp->name;
            $data['updated_at'] = $resource->updated_at;

            array_push($resourceList, $data);
            array_push($appIds, $resource->app_id);
        }

        $appsHasRes = Apps::whereNotIn('id', $appIds)->get();
        $apps = Apps::where('is_deleted', false)->orderBy('id')->get();

        return view('manager.scripts', array(
            'resources' => $resourceList,
            'appsHasRes' => $appsHasRes,
            'apps' => $apps
        ));
    }

    public function getResources($typeId)
    {
        $user = auth()->user();
        if ($user->role != 0) {
            return redirect('/logout'); 
        }

        $cond = AppScript::where('type_id', $typeId);
        $resources = $cond->get();

        $appIds = [];
        $resourceList = [];

        foreach ($resources as $resource) {
            $data = [];
            $data['id'] = $resource->id;
            $data['app_id'] = $resource->app_id;
            $data['name'] = $resource->rApp->name;
            $data['type'] = $resource->rDeviceType->name;

            $updateDate = new DateTime($resource->updated_at);
            $updateDate->setTimezone(new DateTimeZone('Asia/Shanghai'));
            $data['updated_at'] = $updateDate->format("Y/m/d H:i:s");

            array_push($resourceList, $data);
            array_push($appIds, $resource->app_id);
        }

        $appsHasRes = DB::table('apps')->whereNotIn('id', $appIds)->get();
        $apps = DB::table('apps')->where('is_deleted', false)->orderBy('id')->get();

        return view('manager.scripts', array(
            'resources' => $resourceList,
            'typeId' => $typeId,
            'appsHasRes' => $appsHasRes,
            'apps' => $apps
        ));
    }

    public function uploadResource(Request $request)
    {
        $app_id   = $request->app_list;

        $resource = AppScript::where('app_id', $app_id)->first();

        if ($resource != null) {
            return response()->json($resource);//['success'=>false, 'message'=>'resource already exist']);
        }

        $filename = $app_id;

        $file = $request->file('new_file');

        // Save File To Public Storage
        $tempLocation = storage_path().'/'.'app/public/temp';
        $file->storeAs('public/temp', $filename);

        // Get File and Encrypt Content
        $content = File::get($tempLocation.'/'.$filename);

        $DES3_KEY = env('XCS_SECRET', 'LbGqH750ukm7g2fbWqzDbQ5L');
        $DES3_IV = env('XCS_IV', 'jefQJhKG');

        $encrypt = openssl_encrypt($content, "des-ede3-cbc", $DES3_KEY, OPENSSL_RAW_DATA, $DES3_IV);
        
        // Save Encrypted File To Public Storage
        Storage::put('public/app/js/'.$filename, $encrypt);

        // Move File To Resource From Public
        $encryptLocation = storage_path().'/app/public/app/js';
        $realLocation = resource_path().'/js/temp';
        File::move($encryptLocation.'/'.$filename, $realLocation.'/'.$filename);

        File::delete($tempLocation.'/'.$filename);
        File::delete($encryptLocation.'/'.$filename);

        $resource = new AppScript();
        $resource->app_id = $app_id;
        $resource->save();

        return redirect('/scripts');
    }

    public function updateResource(Request $request) {
        $res_id = $request->resource_id;
        $file  = $request->file('file');

        $cond = AppScript::where('id', $res_id);
        $resource = $cond->first();

        if ($resource == null) {
            return response()->json(['success'=>false, 'message'=>'Cannot find a resource. Please create new one.']);
        }

        $app_id = $resource->app_id;
        // Save File To Public Storage
        $tempLocation = storage_path().'/'.'app/public/temp';
        $file->storeAs('public/temp', $app_id);

        // Get File and Encrypt Content
        $content = File::get($tempLocation.'/'.$app_id);

        $DES3_KEY = env('XCS_SECRET', 'LbGqH750ukm7g2fbWqzDbQ5L');
        $DES3_IV = env('XCS_IV', 'jefQJhKG');

        $encrypt = openssl_encrypt($content, "des-ede3-cbc", $DES3_KEY, OPENSSL_RAW_DATA, $DES3_IV);
        
        // Save Encrypted File To Public Storage
        Storage::put('public/app/js/'.$app_id, $encrypt);

        // Move File To Resource From Public
        $encryptLocation = storage_path().'/app/public/app/js';
        $realLocation = resource_path().'/js/temp';
        File::move($encryptLocation.'/'.$app_id, $realLocation.'/'.$app_id);

        File::delete($tempLocation.'/'.$app_id);
        File::delete($encryptLocation.'/'.$app_id);

        $resource->touch();

        return redirect('/scripts');
    }
}
