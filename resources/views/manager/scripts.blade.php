@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Script Management</h2>
                    </div>
                    <div class="card-body">
                        <form style="display: flex">
                            <h4 class="c-grey-900 mB-20" style="flex: 1 1 auto;"></h4>
                            <button class="btn btn-danger" type="button" style="margin-bottom: 20px !important;" id="btn_new_resource">新资源注册</button>
                        </form>
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>应用名</th>
                                    <th>更新日期</th>
                                    <th>过程</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resources as $i=>$resource)
                                <tr>
                                    <td>{{ $resource['app_id'] }}</td>
                                    <td>{{ $resource['name'] }}</td>
                                    <td>{{ $resource['updated_at']}}</td>
                                    <td>
                                        <div class="peers mR-15">
                                            <div class="peer">
                                                <span id="btn_upload_file" class="btn btn-sm btn-tumblr btn_upload_file"  style="background-color: blue;" data-id="{{ $resource['id'] }}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-data-transfer-up"></use>
                                                    </svg>
                                                </span>
                                                <span id="btn_download_file" class="btn btn-sm btn-tumblr btn_download_file"  style="background-color: red;" data-id="{{ $resource['id'] }}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-data-transfer-down"></use>
                                                    </svg>
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
            <!-- /.col-->
        </div>
    </div>
    <div class="modal" id="dlg_new_script">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">新资源注册</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('upload_scripts') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="app_list">请选择应用</label>
                            <select id="app_list" name="app_list" class="form-control">
                                <option value="0" selected>请选择 ...</option>
                                @foreach($appsHasRes as $i=>$app)
                                <option value="{{ $app->id }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">JS文件上载</label>
                            <input type="file" class="form-control" style="border: 1px solid #00000000; padding: 0.375rem 0" id="new_file" name="new_file" />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_add" type="submit">更新应用</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="dlg_update_script">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">资源更新</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('update_scripts') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="visibility: hidden; max-height: 0px;">
                            <label for="resource_id">JS文件上载</label>
                            <input type="text" class="form-control" id="resource_id" name="resource_id">
                        </div>

                        <div class="form-group">
                            <label for="file">JS文件上载</label>
                            <input type="file" class="form-control" style="border: 1px solid #00000000; padding: 0.375rem 0" id="file" name="file" />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_update" type="submit">资源更新</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/manager/scripts.js') }}"></script>

@endsection