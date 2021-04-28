@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>应用管理</h2>
                    </div>
                    <div class="card-body">
                        <form style="display: flex">
                            <h4 class="c-grey-900 mB-20" style="flex: 1 1 auto;"></h4>
                            <button id="btn_new_app" class="btn btn-danger" type="button" style="margin-bottom: 20px !important;">新应用</button>
                        </form>
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>应用名</th>
                                    <th>包名</th>
                                    <th>版本</th>
                                    <th>更新日期</th>
                                    <th>过程</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apps as $i=>$app)
                                <tr>
                                    <td>{{ $app['id'] }}</td>
                                    <td>{{ $app['name'] }}</td>
                                    <td>{{ $app['version'] }}</td>
                                    <td>{{ $app['package_name']}}</td>
                                    <td>{{ $app['updated_at']}}</td>
                                    <td>
                                        <div class="peers mR-15">
                                            <div class="peer">
                                                <button id="btn_edit_app" class="btn btn-sm btn-tumblr btn_edit_app" type="button" style="background-color: blue;" data-id="{{ $app['id'] }}" data-name="{{ $app['name'] }}" data-version="{{ $app['version'] }}" data-package="{{ $app['package_name'] }}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-pencil"></use>
                                                    </svg>
                                                </button>
                                                <button id="btn_delete_app" class="btn btn-sm btn-tumblr btn_delete_app" type="button" style="background-color: red;" data-id="{{ $app['id'] }}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-trash"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="dlg_new_app">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">新应用</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('new_app') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="visibility: hidden; max-height: 0px;">
                            <label class="fw-500">Id</label>
                            <input type="text" class="form-control" id="app_id" name="app_id" placeholder="App ID">
                        </div>
                        <div class="form-group">
                            <label for="app_name">应用名</label>
                            <input type="text" class="form-control" id="app_name" name="app_name" placeholder="App Name">
                        </div>
                        <div class="form-group">
                            <label for="package_name" class="fw-500">包名</label>
                            <input type="text" class="form-control" id="package_name" name="package_name" placeholder="com.example.app">
                        </div>
                        <div class="form-group">
                            <label for="app_version" class="fw-500">版本</label>
                            <input type="text" class="form-control" id="app_version" name="app_version" placeholder="1.0.0">
                        </div>
                        <div class="form-group">
                            <label for="download_link" class="fw-500">下载链接</label>
                            <input type="text" class="form-control" id="download_link" name="download_link" placeholder="https://com.example.com/download/example.apk">
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_add" type="submit">更新应用</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="dlg_edit_app">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">更新应用</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('edit_app') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="visibility: hidden; max-height: 0px;">
                            <label class="fw-500">Id</label>
                            <input type="text" class="form-control" id="update_app_id" name="update_app_id" placeholder="App ID">
                        </div>
                        <div class="form-group">
                            <label for="app_name">应用名</label>
                            <input type="text" class="form-control" id="update_app_name" name="update_app_name" placeholder="App Name">
                        </div>
                        <div class="form-group">
                            <label for="package_name" class="fw-500">包名</label>
                            <input type="text" class="form-control" id="update_package_name" name="update_package_name" placeholder="com.example.app">
                        </div>
                        <div class="form-group">
                            <label for="app_version" class="fw-500">版本</label>
                            <input type="text" class="form-control" id="update_app_version" name="update_app_version" placeholder="1.0.0">
                        </div>
                        <div class="form-group">
                            <label for="download_link" class="fw-500">下载链接</label>
                            <input type="text" class="form-control" id="update_download_link" name="update_download_link" placeholder="https://com.example.com/download/example.apk">
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_update" type="submit">更新应用</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="dlg_delete_app">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">{{ Lang::get('localizedStr.app_delete') }}</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('delete_app') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="visibility: hidden; max-height: 0px;">
                            <label class="fw-500">Id</label>
                            <input type="text" class="form-control" id="delete_id" name="delete_id" placeholder="App ID">
                        </div>
                        <div class="form-group" style="text-align: center;">
                            <label class="fw-500">{{ Lang::get('localizedStr.app_msg_delete') }}</label>
                        </div>
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-6" style="text-align: center;">
                                <button class="btn btn-primary cur-p" id="btn_cancel" data-dismiss="modal">{{ Lang::get('localizedStr.btn_cancel') }}</button>
                            </div>
                            <div class="col-md-6" style="text-align: center;">
                                <button class="btn btn-primary cur-p" id="btn_delete" type="submit">{{ Lang::get('localizedStr.btn_delete') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/manager/apps.js') }}"></script>

@endsection