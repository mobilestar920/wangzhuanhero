<?php

namespace App\Http\Controllers\Manager;

use App\Apps;
use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ManageAppController extends Controller
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
        $cond = Apps::where('is_deleted', false)->orderBy('id');
        $apps = $cond->get();

        $appList = [];
        foreach ($apps as $i => $app) {
            $data = [];
            $data['id'] = $app->id;
            $data['name'] = $app->name;
            $data['version'] = $app->version;
            $data['package_name'] = $app->package_name;

            $expire_at = new DateTime($app->updated_at);
            $expire_at->setTimezone(new DateTimeZone('Asia/Shanghai'));
            $data['updated_at'] = $expire_at->format("Y/m/d H:i:s");

            array_push($appList, $data);
        }

        return view('manager.apps', array('apps' => $appList));
    }

    public function editApp(Request $request) {
        $app_id = $request->update_app_id;

        $app = Apps::where('id', $app_id)->first();

        if ($app == null) {
            $app = new Apps();
        }

        $app->name = $request->update_app_name;
        $app->version = $request->update_app_version;
        $app->package_name = $request->update_package_name;
        $app->download_url = $request->update_download_link;
        $app->save();

        return redirect('/apps');
    }

    public function deleteApp(Request $request) {
        $app_id = $request->delete_id;

        $app = Apps::where('id', $app_id)->first();

        if ($app == null) {
            return response()->json(['success'=>false, 'message'=>'application does not exist']);
        }

        $filename = $app->id.'.apk';
        $realLocation = resource_path().'/apk'.'/'.strval($filename);
        
        if (File::exists($realLocation)) {
            File::delete($realLocation);
        }

        $app->is_deleted = true;
        $app->save();

        return redirect('/apps');
    }

    public function addNewApp(Request $request) {
        $app = Apps::where('package_name', $request->package_name)->orderBy('id')->first();
        
        if ($app == null) {
            $app = new Apps();
        } else if (!$app->is_deleted) {
            return redirect('/apps');
        }

        $app->name = $request->app_name;
        $app->package_name = $request->package_name;
        $app->version = $request->app_version;
        $app->download_url = $request->download_link;
        $app->is_deleted = false;
        $app->save();

        return redirect('/apps');
    }
}