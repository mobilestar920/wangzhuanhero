@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Apk Management</h2>
                    </div>
                    <div class="card-body">
                        <form style="display: flex">
                            <h4 class="c-grey-900 mB-20" style="flex: 1 1 auto;"></h4>
                            <button id="btn_new_version" class="btn btn-danger" type="button" style="margin-bottom: 20px !important;">新版本</button>
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
                                    <td>{{ $app->id }}</td>
                                    <td>{{ $app->name }}</td>
                                    <td>{{ $app->package_name }}</td>
                                    <td>{{ $app->version}}</td>
                                    <td>{{ $app->updated_at}}</td>
                                    <td>
                                        <div class="peers mR-15">
                                            <div class="peer">
                                                <span id="edit_app" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5" data-id="{{ $app->id }}" data-name="{{ $app->name }}" data-version="{{ $app->version }}" data-package="{{ $app->package_name }}">
                                                    <i class="ti-pencil"></i>
                                                </span>
                                            </div>
                                            <div class="peer">
                                                <span id="delete_app" class="td-n c-pink-500 cH-blue-500 fsz-md p-5" data-id="{{ $app->id }}">
                                                    <i class="ti-trash"></i>
                                                </span>
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

    <!-- Dialog for Upload New Version -->
    <div class="modal" id="dlg_new_version">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">新版本</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addNewVersion') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="app_name">应用名</label>
                            <input type="text" class="form-control" id="app_name" name="app_name" placeholder="App Name" value="网赚英雄">
                        </div>
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-6">
                                <label for="package_name" class="fw-500">包名</label>
                                <input type="text" class="form-control" id="package_name" name="package_name" placeholder="com.example.app">
                            </div>
                            <div class="col-md-6">
                                <label for="app_version" class="fw-500">版本</label>
                                <input type="text" class="form-control" id="app_version" name="app_version" placeholder="1.0.0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file">应用包</label>
                            <input type="file" class="form-control" style="border: 1px solid #00000000; padding: 0.375rem 0" id="file" name="file" multiple />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_update" type="submit">{{ Lang::get('localizedStr.btn_done') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/manager/myapps.js') }}"></script>

@endsection