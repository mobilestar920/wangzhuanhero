@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>销售状态</h2>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>类型</th>
                                    <th>激活数</th>
                                    <th>销售数量</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($codes as $type=>$code)
                                <tr>
                                    <td>{{ $type + 1 }}</td>
                                    @if ($type == 0) 
                                    <td>7日</td>
                                    @elseif ($type == 1)
                                    <td>15日</td>
                                    @else
                                    <td>30日</td>
                                    @endif

                                    <td>{{ $code['total'] }}</td>
                                    <td>{{ $code['selled'] }}</td>
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
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/seller/sellerstatus.js') }}"></script>

@endsection