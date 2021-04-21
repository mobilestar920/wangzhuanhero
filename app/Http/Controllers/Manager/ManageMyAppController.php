<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\MyApps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ManageMyAppController extends Controller
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
        $cond = MyApps::where('id', '>', -1)->orderBy('created_at', 'desc');
        $my_apps = $cond->get();
        return view('manager.myapps', array('apps' => $my_apps));
    }


    public function addNewVersion(Request $request) {
        $app_name = $request->app_name;
        $version = $request->app_version;
        $package_name = $request->package_name;

        $cond = MyApps::where('package_name', $package_name);
        $numOfHigh = $cond->where('version', '>', $version)->count();
        
        if ($numOfHigh > 0) {
            return response() -> json(['success'=>false, 'message'=>'This app version is lower than current version.']);
        }

        $app = new MyApps();
        $app->name = $app_name;
        $app->version = $version;
        $app->package_name = $package_name;
        $app->save();

        $filename = $app->id.'.apk';
        $file = $request->file('file');

        // Save File To Public Storage
        $tempLocation = storage_path().'/'.'app/public/caishen'.'/'.$filename;
        $file->storeAs('public/caishen', $filename);

        $realLocation = resource_path().'/caishen'.'/'.strval($filename);
        
        if (File::exists($realLocation)) {
            File::delete($realLocation);
        }
        
        File::move($tempLocation, $realLocation);
        File::delete($tempLocation);

        return $this->index();
    }
}
