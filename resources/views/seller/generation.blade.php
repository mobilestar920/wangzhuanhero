@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ Lang::get('localizedStr.title_generate_code') }}</h2>
                    </div>
                    <div class="card-body">
                        <form style="display: flex">
                            <div class="c-grey-900 mB-20" style="flex: 1 1 auto; margin-right: 40px;">
                                <select class="form-control" id="code_type" name="code_type">
                                    <option value="0">{{ Lang::get('localizedStr.seven_days') }}</option>
                                    <option value="1">{{ Lang::get('localizedStr.half_month') }}</option>
                                    <option value="2">{{ Lang::get('localizedStr.one_month') }}</option>
                                </select>
                            </div>
                            <button id="btn_code_generation" class="btn btn-danger" type="button" style="margin-bottom: 20px !important;">Generate</button>
                        </form>
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ Lang::get('localizedStr.verification_code') }}</th>
                                    <th>{{ Lang::get('localizedStr.created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($codes as $i=>$code)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $code['code'] }}</td>
                                    <td>{{ $code['created_at'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>

    <div class="modal" id="dlg_code_generation">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15" style="margin: 20px;">
                    <h5 class="m-0">Verification Code Generator</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('codeGenerate') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="code_type">Type</label>
                            <select id="code_type" name="code_type" class="form-control">
                                <option value="0" selected>{{ Lang::get('localizedStr.seven_days') }}</option>
                                <option value="1">{{ Lang::get('localizedStr.half_month') }}</option>
                                <option value="2">{{ Lang::get('localizedStr.one_month') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="code_count" class="fw-500">Count</label>
                            <input type="text" class="form-control" id="code_count" name="code_count" placeholder="30">
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_add" type="submit">Generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/seller/generation.js') }}"></script>

@endsection