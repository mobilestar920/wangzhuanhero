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
                            <button class="btn btn-danger" type="button" style="margin-bottom: 20px !important;" id="btn_new_resource">{{ Lang::get('localizedStr.resource_new') }}</button>
                        </form>
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{ Lang::get('localizedStr.resource_app_name') }}</th>
                                    <th>{{ Lang::get('localizedStr.resource_update_date') }}</th>
                                    <th>{{ Lang::get('localizedStr.user_action') }}</th>
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
                                                <button id="btn_upload_file" class="btn btn-sm btn-tumblr" type="button" style="background-color: blue;" data-id="{{ $resource['id'] }}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-data-transfer-up"></use>
                                                    </svg>
                                                </button>
                                                <button id="btn_download_file" class="btn btn-sm btn-tumblr" type="button" style="background-color: red;" data-id="{{ $resource['id'] }}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-data-transfer-down"></use>
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
            <!-- /.col-->
        </div>
    </div>
    <div class="modal" id="dlg_new_script">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">{{ Lang::get('localizedStr.resource_new') }}</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('upload_scripts') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="app_list">{{ Lang::get('localizedStr.resource_choose_app') }}</label>
                            <select id="app_list" name="app_list" class="form-control">
                                <option value="0" selected>{{ Lang::get('localizedStr.choose_option') }}</option>
                                @foreach($appsHasRes as $i=>$app)
                                <option value="{{ $app->id }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">{{ Lang::get('localizedStr.resource_choose_file') }}</label>
                            <input type="file" class="form-control" style="border: 1px solid #00000000; padding: 0.375rem 0" id="file" name="file" />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_add" type="submit">{{ Lang::get('localizedStr.app_update') }}</button>
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
                    <h5 class="m-0">{{ Lang::get('localizedStr.resource_update') }}</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('update_scripts') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="visibility: hidden; max-height: 0px;">
                            <label for="resource_id">{{ Lang::get('localizedStr.resource_choose_file') }}</label>
                            <input type="text" class="form-control" id="resource_id" name="resource_id">
                        </div>

                        <div class="form-group">
                            <label for="file">{{ Lang::get('localizedStr.resource_choose_file') }}</label>
                            <input type="file" class="form-control" style="border: 1px solid #00000000; padding: 0.375rem 0" id="file" name="file" />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_add" type="submit">{{ Lang::get('localizedStr.resource_update') }}</button>
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