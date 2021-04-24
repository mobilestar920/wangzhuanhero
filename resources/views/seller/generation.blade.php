@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>激活码</h2>
                    </div>
                    <div class="card-body">
                        <form style="display: flex">
                            <div class="c-grey-900 mB-20" style="flex: 1 1 auto; margin-right: 40px;">
                                <select class="form-control" id="code_type" name="code_type">
                                    <option value="0">7日</option>
                                    <option value="1">15日</option>
                                    <option value="2">30日</option>
                                </select>
                            </div>
                            <button id="btn_code_generation" class="btn btn-danger" type="button" style="margin-bottom: 20px !important;">产生激活</button>
                        </form>
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>激活码</th>
                                    <th>产生日期</th>
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
                    <h5 class="m-0">激活数</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('codeGenerate') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="code_type">激活码类型</label>
                            <select id="code_type" name="code_type" class="form-control">
                                <option value="0" selected>7日</option>
                                <option value="1">15日</option>
                                <option value="2">30日</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="code_count" class="fw-500">激活数</label>
                            <input type="text" class="form-control" id="code_count" name="code_count" placeholder="30">
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_add" type="submit">激活数</button>
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