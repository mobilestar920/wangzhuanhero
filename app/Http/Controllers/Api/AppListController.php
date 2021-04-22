<?php

namespace App\Http\Controllers\Api;

use App\AppResources;
use App\Apps;
use App\AppScript;
use App\Http\Controllers\Controller;
use App\MyApps;
use App\News;
use App\VerifyCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppListController extends Controller {

    /**
     * Get App List
     * @method GET
     * 
     * @return appList - Get App List
     */
    public function index() {
        $response = [];

        $cond = Apps::where('is_deleted', false)->orderBy('id');
        $response['success'] = true;
        $response['apps'] = $cond->get();
        
        return response()->json($response);
    }

    public function getIdFromApp($app) {
        return $app->id;
    }

    public function downloadableAppIds() {
        $user = auth()->user();
        $cond = Apps::where('id','>',-1);
        $apps = $cond->get();

        $appIds = [];
        foreach ($apps as $i => $app) {
            $resource = AppScript::where('app_id', $app->id)->first();
            $appResource = [];
            $appResource['app_id'] = $app->id;
            
            if ($resource == null) {
                // return response()->json(['success'=>false, 'message'=>'Cannot find resource for your device.']);
            } else {
                $appResource['timestamp'] = $resource->updated_at->getTimestamp();
                array_push($appIds, $appResource);
            }
        }

        $response['success'] = true;
        $response['app_ids'] = $appIds;
        
        return response()->json($response);
    }

    public function download($id) {
        $app = Apps::where('id', $id)->first();
        
        if ($app != null) {
            $fileName = strval($id).'.apk';
            $filePath = resource_path().'/'.'apk/'.$fileName;

            $num_download = $app->num_download;
            $app->num_download = $num_download + 1;
            $app->save();

            return response()->download($filePath, $fileName);     
        } else {
            return response()->json(['success'=>false, 'message'=>'下载的应用不存在。']);
        }
    }

    public function resourceDownload($id) {
        $user = auth()->user();
        
        $fileName = strval($id);
        $filePath = resource_path().'/'.'js/temp/'.$fileName;
        return response()->download($filePath, $fileName); 
    }

    public function changbaoDownload($id) {
        $user = auth()->user();        
        $fileName = strval($id);
        $filePath = resource_path().'/'.'js/changbao/'.$fileName;
        return response()->download($filePath, $fileName); 
    }

    public function caishenDownload($id) {
        $app = MyApps::where('id', $id)->first();
        
        if ($app != null) {
            $fileName = strval($id).'.apk';
            $filePath = resource_path().'/'.'caishen/'.$fileName;

            return response()->download($filePath, $fileName);     
        } else {
            return response()->json(['success'=>false, 'message'=>'下载的应用不存在。']);
        }
    }

    public function caishenFreeDownload() {
        $app = MyApps::where('id','>', -1)->orderBy('created_at', 'desc')->first();
        
        if ($app != null) {
            $fileName = strval($app->id).'.apk';
            $filePath = resource_path().'/'.'caishen/'.$fileName;

            return response()->download($filePath, $fileName);     
        } else {
            return response()->json(['success'=>false, 'message'=>'下载的应用不存在。']);
        }
    }

    public function getLatestNews() {
        $condition = News::where('id', '>', -1);
        $news = $condition->orderBy('created_at', 'desc')->first();
        
        $response = [];
        $response['success'] = true;
        $response['news'] = $news;

        return response()->json($response);
    }

    public function getMileResource($id) {
        $user = auth()->user();
        $device = $user->rDevice;
        
        if ($device == null) {
            return response()->json(['success'=>false, 'message'=>'手机没有登记。请咨询管理员。']);
        }

        $fileName = strval($id);
        $filePath = resource_path().'/'.'js/mile/'.$fileName;
        return response()->download($filePath, $fileName); 
    }

    public function userAvailable(Request $request) {

        return response()->json(['success' => true, 'message' => '使用可以。']);
        $user = auth()->user();
        $device_uuid = $request->device_uuid;

        if ($user->device_id != $device_uuid) {
            return response()->json(['success' => false, 'message' => '你得账号已被其他用户使用。']);
        }

        $codeUsing = VerifyCode::where('customer_id', $user->id)->orderBy('updated_at', 'desc')->first();
        if ($codeUsing == null) {
            $expire_date = $user->created_at->addDays(1);
            if (Carbon::now() > $expire_date) {
                return response()->json(['success' => false, 'message' => '使用期限已满。']);
            } else {
                return response()->json(['success' => true, 'message' => '使用可以。']);
            }
        }

        $availableDays = 0;
        if ($codeUsing->type == 0) {
            $availableDays = 7;
        } else if ($codeUsing->type == 1) {
            $availableDays = 15;
        } else {
            $availableDays = 30;
        }

        $current = Carbon::now();
        $expire_date = $codeUsing->updated_at->addDays($availableDays);
        if ($current > $expire_date) {
            return response()->json(['success' => false, 'message' => '使用期限已满。']);
        } else {
            return response()->json(['success' => true, 'message' => '使用可以。']);
        }
    }
}